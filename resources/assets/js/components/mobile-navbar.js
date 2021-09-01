class MobileNavbar {
    constructor(mobileMenu, navList, navLinks) {
        this.mobileMenu = document.querySelector(mobileMenu);
        this.navList = document.querySelector(navList);
        this.navLinks = document.querySelectorAll(navLinks);
        this.activeClass = 'active';
    }

    init() {
        this.mobileMenu.addEventListener('click', () => {
            this.handleClick();
        });
    }

    handleClick() {
        this.navList.classList.toggle(this.activeClass);
        this.mobileMenu.classList.toggle(this.activeClass);
        this.animateLinks();
    }

    animateLinks() {
        this.navLinks.forEach((link, index) => {
            link.style.animation ? (link.style.animation = '') : (link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`)
        });
    }

}
const mobileNavbar = new MobileNavbar('#bars', '.header__nav__list', '.header__nav__list__itens');

mobileNavbar.init();