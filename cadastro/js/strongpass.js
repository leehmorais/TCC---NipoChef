
function checkPasswordRequirements(password) {
 // Verifica as exigências
 const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password),
        special: /[\W_]/.test(password),
    };

    // Atualiza a cor das exigências
    document.getElementById("length").style.color = requirements.length ? "green" : "red";
    document.getElementById("uppercase").style.color = requirements.uppercase ? "green" : "red";
    document.getElementById("lowercase").style.color = requirements.lowercase ? "green" : "red";
    document.getElementById("numero").style.color = requirements.number ? "green" : "red";
    document.getElementById("special").style.color = requirements.special ? "green" : "red";
    }

    document.getElementById("password").addEventListener("input", function() {
        checkPasswordRequirements(this.value);
    });
