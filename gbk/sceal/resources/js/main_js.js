$(document).ready(function(){
    /*toggle nav sidebar*/
    var btnSidebar = document.querySelector(".toggle-sidebar");
    btnSidebar.addEventListener('click', function(){
        this.classList.toggle("active");
        this.childNodes[0].classList.toggle("active");
        var sidebar = document.querySelector(".wrap-layout__sidebar");
        sidebar.classList.toggle("active");
    });
    /*show panel*/
    function Panel() {
        var col = document.querySelectorAll(".content-layout__posts .col, .content-layout__metrics .col");
        for(f = 0; f < col.length; f++) {
            function showPanel() {
                this.classList.toggle("active");
            }
            col[f].addEventListener('click', showPanel);
        }
    }
    function showPanelSidebar() {
        var btnShow = document.querySelectorAll(".main-scroll .wrap-layout__box");
        for (a = 0; a < btnShow.length; a++) {
            function showPanel() {
                this.classList.toggle("active");
                this.classList.toggle("selected");
            }
            btnShow[a].addEventListener('click', showPanel);
        }
    }
    Panel();
    showPanelSidebar();
});