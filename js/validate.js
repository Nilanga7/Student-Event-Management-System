// Client-Side Form Validation for Student Event Management System

// Registration Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name');
	    const studentId = document.getElementById('studentId');
	    const phone = document.getElementById('phone');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            
            let isValid = true;
            
            // Reset previous validation states
            resetValidation([name, studentId, phone, email, password, confirmPassword]);
            
            // Validate Name
            if (name.value.trim() === '') {
                showError(name, 'Please enter your full name.');
                isValid = false;
            }

	    // Validate studentId
            if (studentId.value.trim() === '') {
                showError(name, 'Please enter your student ID number.');
                isValid = false;
            }

	    // Validate phone
            if (phone.value.trim() === '') {
                showError(name, 'Please enter valid contact number.');
                isValid = false;
            }
            
            // Validate Email
            if (!isValidEmail(email.value)) {
                showError(email, 'Please enter a valid email address.');
                isValid = false;
            }
            
            // Validate Password
            if (password.value.length < 6) {
                showError(password, 'Password must be at least 6 characters long.');
                isValid = false;
            }
            
            // Validate Confirm Password
            if (password.value !== confirmPassword.value) {
                showError(confirmPassword, 'Passwords do not match.');
                isValid = false;
            }
            
            if (isValid) {
                registerForm.submit();
            }
        });
    }
    
    // Login Form Validation
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            
            let isValid = true;
            
            // Reset previous validation states
            resetValidation([email, password]);
            
            // Validate Email
            if (!isValidEmail(email.value)) {
                showError(email, 'Please enter a valid email address.');
                isValid = false;
            }
            
            // Validate Password
            if (password.value.trim() === '') {
                showError(password, 'Please enter your password.');
                isValid = false;
            }
            
            if (isValid) {
                loginForm.submit();
            }
        });
    }
});

// Helper function to validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Helper function to show error
function showError(input, message) {
    input.classList.add('is-invalid');
    const feedback = input.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.textContent = message;
    }
}

// Helper function to reset validation
function resetValidation(inputs) {
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
        input.classList.remove('is-valid');
    });
}

// Real-time validation feedback
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.value.trim() !== '') {
            if (this.type === 'email') {
                if (isValidEmail(this.value)) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            } else if (this.id === 'password' && this.value.length >= 6) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else if (this.id === 'confirm_password') {
                const password = document.getElementById('password');
                if (password && this.value === password.value) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            } else if (this.id === 'name' && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        }
    });
});