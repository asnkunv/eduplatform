# Security Considerations

## ⚠️ IMPORTANT DISCLAIMER

This project is designed for **educational purposes** and **local development only**. It contains several security vulnerabilities that must be addressed before deploying to production.

## Current Security Issues

### 1. SQL Injection Vulnerabilities

**Problem**: Many queries use string concatenation instead of prepared statements.

**Affected Files:**
- `admin/addcourse.php`
- `admin/deletecourse.php`
- `auth/loginaction.php`
- `auth/registeraction.php`
- `teacher/setprice.php`

**Example Vulnerable Code:**
```php
// ❌ VULNERABLE
$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
```

**Fix:**
```php
// ✅ SECURE
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
```

---

### 2. Plain Text Password Storage

**Problem**: Passwords are stored in plain text in the database.

**Affected Files:**
- `auth/registeraction.php`
- `auth/loginaction.php`

**Current Code:**
```php
// ❌ VULNERABLE
$password = $_POST['password'];
$sql = "INSERT INTO users (..., password) VALUES (..., '$password')";
```

**Fix:**
```php
// ✅ SECURE
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$sql = "INSERT INTO users (..., password) VALUES (..., ?)";

// For login verification:
if (password_verify($input_password, $hashed_password)) {
    // Login successful
}
```

---

### 3. Missing Session Security

**Problem**: No session timeout, regeneration, or secure flags.

**Current Code:**
```php
// ❌ BASIC
session_start();
$_SESSION['userid'] = $user['userid'];
```

**Fix:**
```php
// ✅ SECURE
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // If using HTTPS
ini_set('session.cookie_samesite', 'Strict');

session_start();
session_regenerate_id(true); // Prevent session fixation

// Set session timeout
$_SESSION['last_activity'] = time();
```

---

### 4. Cross-Site Scripting (XSS)

**Problem**: User input is echoed without proper escaping.

**Affected Files:**
- Multiple dashboard files
- `student/mycourses.php`
- `teacher/teacherdashboard.php`

**Example:**
```php
// ❌ VULNERABLE
echo $row['coursename'];
```

**Fix:**
```php
// ✅ SECURE
echo htmlspecialchars($row['coursename'], ENT_QUOTES, 'UTF-8');
```

---

### 5. Missing CSRF Protection

**Problem**: Forms don't have CSRF tokens to prevent cross-site request forgery.

**Current Code:**
```html
<!-- ❌ VULNERABLE -->
<form method="post" action="addcourse.php">
    <input type="text" name="coursename">
    <input type="submit">
</form>
```

**Fix:**
```php
// Generate token
<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!-- ✅ SECURE -->
<form method="post" action="addcourse.php">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="text" name="coursename">
    <input type="submit">
</form>

<!-- Verify token -->
<?php
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die('CSRF token validation failed');
}
?>
```

---

### 6. Missing Input Validation

**Problem**: No server-side validation of user inputs.

**Example Issues:**
- Email format not validated
- Phone numbers not validated
- Course duration can be negative
- No maximum length checks

**Fix:**
```php
// ✅ SECURE
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateDuration($duration) {
    return is_numeric($duration) && $duration > 0 && $duration <= 52;
}

// Use before processing
if (!validateEmail($_POST['email'])) {
    die("Invalid email format");
}
```

---

### 7. Error Information Disclosure

**Problem**: Detailed error messages expose system information.

**Current Code:**
```php
// ❌ REVEALS TOO MUCH
echo "Error: " . $conn->error;
```

**Fix:**
```php
// ✅ SECURE
error_log("Database error: " . $conn->error); // Log for debugging
echo "An error occurred. Please try again later."; // User-friendly message
```

---

### 8. No Rate Limiting

**Problem**: No protection against brute force attacks.

**Vulnerability**: Login page can be attacked unlimited times.

**Fix**: Implement rate limiting:
```php
// ✅ SECURE
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

if ($_SESSION['login_attempts'] >= 5) {
    $time_passed = time() - $_SESSION['last_attempt_time'];
    if ($time_passed < 900) { // 15 minutes
        die("Too many login attempts. Please try again later.");
    } else {
        $_SESSION['login_attempts'] = 0;
    }
}
```

---

### 9. Missing Authorization Checks

**Problem**: No verification that users can access resources they request.

**Example**: Student could potentially modify another student's enrollment.

**Fix:**
```php
// ✅ SECURE
$stmt = $conn->prepare("SELECT * FROM enrollments WHERE enrollid = ? AND userid = ?");
$stmt->bind_param("ii", $enrollid, $_SESSION['userid']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Unauthorized access");
}
```

---

### 10. Insecure Direct Object References

**Problem**: IDs passed directly in forms without validation.

**Current Code:**
```php
// ❌ VULNERABLE
$courseid = $_POST['courseid'];
$sql = "DELETE FROM courses WHERE courseid = '$courseid'";
```

**Fix:**
```php
// ✅ SECURE
$courseid = filter_input(INPUT_POST, 'courseid', FILTER_VALIDATE_INT);
if ($courseid === false) {
    die("Invalid course ID");
}

// Also check if user has permission to delete
```

---

## Production Deployment Checklist

Before deploying this application to production:

- [ ] Implement password hashing with `password_hash()`
- [ ] Convert all SQL queries to prepared statements
- [ ] Add CSRF tokens to all forms
- [ ] Implement proper session management
- [ ] Add input validation for all user inputs
- [ ] Implement XSS protection (htmlspecialchars)
- [ ] Add rate limiting for login attempts
- [ ] Use HTTPS/SSL certificates
- [ ] Implement proper error handling (don't expose system info)
- [ ] Add authorization checks for all sensitive operations
- [ ] Enable PHP error logging (not display)
- [ ] Set secure PHP ini settings
- [ ] Implement backup and recovery procedures
- [ ] Add logging and monitoring
- [ ] Perform security audit/penetration testing
- [ ] Update default credentials
- [ ] Remove or secure phpMyAdmin access
- [ ] Implement Content Security Policy headers
- [ ] Add HTTP security headers

## Recommended PHP Configuration

```php
// php.ini settings for production
display_errors = Off
log_errors = On
error_log = /path/to/php-error.log
expose_php = Off
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
```

## Security Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)
- [SQL Injection Prevention](https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html)

## Reporting Security Issues

If you discover a security vulnerability, please email [security@example.com] instead of using the issue tracker.

---

**Remember**: Security is not a feature, it's a requirement. Never deploy this application in its current state to a production environment.
