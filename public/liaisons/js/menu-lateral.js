document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const btn = document.getElementById("btnSidebar");
    if (!sidebar || !btn) return;

    btn.addEventListener("click", () => {
        sidebar.classList.toggle("sidebar--open");
    });
});