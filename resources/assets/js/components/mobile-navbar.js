class MobileNavbar {
    constructor(mobileMenu, navList, navLinks) {
      this.mobileMenu = document.querySelector(mobileMenu);
      this.navList = document.querySelectorAll(navList);
      this.navLinks = document.querySelectorAll(navLinks);
      this.activeClass = 'active';

      this.init();
    }

    init() {
      this.mobileMenu.addEventListener('click', () => {
        this.handleClick();
      });
    }

    handleClick() {
      this.navList.forEach(list => {
        list.classList.toggle(this.activeClass);
      })
      this.mobileMenu.classList.toggle(this.activeClass);
      this.animateLinks();
    }

    animateLinks() {
      this.navLinks.forEach((link, index) => {
        link.style.animation ? (link.style.animation = '') : (link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`)
      });
    }

}
