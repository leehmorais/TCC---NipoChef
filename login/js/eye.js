function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.type === "password" ? "text" : "password";
    input.type = type;
}
