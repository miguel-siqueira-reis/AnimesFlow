export class TableView {
  constructor(nameTable, limit=false, search=false) {
    this.nameTable = nameTable;
    this.content = document.querySelector('.'+nameTable);
    this.capitalized = this.nameTable[0].toUpperCase() + this.nameTable.substr(1);
    this.selectId = limit ? this.nameTable+'Limit' : false;
    this.searchId = search ? this.nameTable+'Search' : false;
    this.theadElement = () => document.querySelector(`.${this.nameTable}__tr`)
    this.tbodyElement = () => document.querySelector(`.${this.nameTable}_table__content.body`);
    this.tableElement = () => document.querySelector(`.${this.nameTable}_table__content__midle__table`);
    this.paginatorHtml = () => document.querySelector(`.${this.nameTable}__paginator__place`);
    this.paginatorInfo = () => document.querySelector(`.${this.nameTable}__info`);
  }

  createTable(thead, tbody, paginator = false) {

    const div = document.createElement('div');
    div.classList.add(`${this.nameTable}_table`);
    div.classList.add('default_table');

    div.innerHTML = `
        <div class="${this.nameTable}_table__title default_table__title"><i class="fas fa-table"></i> Table ${this.capitalized}</div>
        <div class="${this.nameTable}_table__content default_table__content">
          <div class="${this.nameTable}_table__content__top default_table__content__top">
            ${this.select() || ''}
            ${this.search() || ''}
          </div>
          <div class="${this.nameTable}_table__content__midle default_table__content__midle">
            <table class="${this.nameTable}_table__content__midle__table default_table__content__midle__table table">
              <thead class="${this.nameTable}_table__content__midle__table__thead default_table__content__midle__table__thead thead">
              ${thead}
              </thead>
              <tbody class="${this.nameTable}_table__content__midle__table__tbody default_table__content__midle__table__tbody body ${this.nameTable}_table__content">
                ${tbody}
              </tbody>
            </table>
          </div>
        <div class="${this.nameTable}_table__content__bottom  default_table__content__bottom">
          ${this.paginator(paginator) || ''}
        </div>
    `;

    return div;
  }

  createTbody(tbody, argsData=false) {
    let tds = '';

    tbody.forEach(elementTd => {
      tds += `
        <td class="${this.nameTable}__td default__td td">${elementTd}</td>
      `;
    })

    let dataHtml = false;

    if (!(Object.keys(argsData).length === 0)) {
      dataHtml = '';
      Object.keys(argsData).forEach(data => {
        dataHtml += `data-${data}="${argsData[data]}" `;
      });
    }

    return `
      <tr ${dataHtml||''} class="${this.nameTable}__tr default__tr tr content">
        ${tds}
      </tr>
    `;
  }

  createThead(arrayTd) {
    let ths = '';

    arrayTd.forEach(elementTh => {
      ths += `
        <th class="${this.nameTable}_table__content__midle__table__thead_th default_table__content__midle__table__thead_th th ${this.nameTable}__th">${elementTh}</th> 
      `;
    })

    this.contentThead = `
      <tr class="tr ${this.nameTable}__tr default__tr">
        ${ths}
      </tr>
    `;

    return this.contentThead;
  }


  select() {
    if (!this.selectId) return '';

    return `
      <div class="${this.nameTable}_table__content__top__limit default_table__content__top__limit">
        <label for="select_limit_${this.nameTable}_table">
          <select id="${this.selectId}" class="${this.nameTable}_table__content__top__limit__select default_table__content__top__limit__select">
          <option class="${this.nameTable}__option" value="1">1</option>
            <option class="${this.nameTable}__option" value="5">5</option>
            <option class="${this.nameTable}__option" value="10">10</option>
            <option class="${this.nameTable}__option" value="15">15</option>
            <option class="${this.nameTable}__option" value="20">20</option>
            <option class="${this.nameTable}__option" value="25">25</option>
          </select>
           entries per page
        </label>
      </div>
    `;
  }

  search() {
    if (!this.searchId) return '';

    return `
      <div class="${this.nameTable}_table__content__top__search default_table__content__top__search">
        <input id="${this.searchId}" type="text" placeholder="Search...">
      </div>
    `;
  }

  paginator(paginator) {
    if (!paginator) return '';
    return `
      <div class="info ${this.nameTable}__info default__info">${paginator.info}</div>
          <div class="${this.nameTable}_table__content__bottom__paginator default_table__content__bottom__paginator">
            <div class="paginator ${this.nameTable}__paginator__place default__paginator__place default__paginator__place">
              ${paginator.pages}
            </div>
          </div>
        </div>
    `;
  }

  createAction(actions) {
    if (actions[0]) {
      let actionlet = '';
      actions.forEach(action => {
        actionlet += `<a href="${action.link}" class="${this.nameTable}__action default__action btn">${action.name}</a>`;
      })
      return actionlet;
    }
    return `<a href="${actions.link}" class="${this.nameTable}__action default__action btn">${actions.name}</a>`;

  }

  getPaginator(paginator) {

    let beforePage = '';

    if (paginator['current_page'] !== 1) {
      beforePage = `<div data-page="1" class="paginator_page ${this.nameTable+'__paginator'} first_page"><<</div>`;
    }
    if (paginator['current_page'] === 2 || paginator['current_page'] === 3) {
      beforePage = `<div data-page="1" class="paginator_page ${this.nameTable+'__paginator'} first_page">1</div>`;
    }
    const ivalue = paginator['current_page'] > 3 ?  paginator['current_page'] - 2 : 2;

    for (let i = ivalue; i < paginator['current_page']; i++) {
      beforePage += `
        <div data-page="${i}" class="before_page ${this.nameTable+'__paginator'} paginator_page">${i}</div>
      `;
    }

    let next_page = '';
    let total = paginator['pages']-paginator['current_page'];

    let ivalue2 = total > 2 ? paginator['current_page'] + 2 : paginator['current_page'];
    ivalue2 = total === 2 ? paginator['current_page'] + 1 : ivalue2;
    for (let i = paginator['current_page'] + 1; i <= ivalue2; i++) {
      next_page += `
        <div data-page="${i}" class="next_page ${this.nameTable+'__paginator'} paginator_page">${i}</div>
      `;
    }

    if (paginator['current_page'] !== paginator['pages'] && paginator['current_page'] !== paginator['pages']-1 && paginator['current_page'] !== paginator['pages']-2) {
      next_page += `<div data-page="${paginator['pages']}" class="last_page ${this.nameTable+'__paginator'} paginator_page">>></div>`;
    }
    if (paginator['current_page'] === paginator['pages']-1 || paginator['current_page'] === paginator['pages']-2) {
      next_page += `<div data-page="${paginator['pages']}" class="last_page ${this.nameTable+'__paginator'} paginator_page">${paginator['pages']}</div>`;
    }

    const current = `<div data-page="${paginator['current_page']}" class="current_page ${this.nameTable+'__paginator'} paginator_page active">${paginator['current_page']}</div>`

    return {
      pages: `
        ${beforePage}
        ${current}
        ${next_page}
      `,
      info: `<div class="${this.nameTable}_table__content__bottom__info default_table__content__bottom__info">Showing ${paginator['limit']} to ${paginator['current_page']} of ${paginator['total']} entries</div>`
    }
  }

  update(args) {
    const tbodyElement = this.tbodyElement();
    const paginatorHtml = this.paginatorHtml();
    const paginatorInfo = this.paginatorInfo();
    const theadElement = this.theadElement();

    if (!tbodyElement) return;

    tbodyElement.innerHTML = '';

    if (!args['data'][0]) return this.error(args['error']||"não foi posivel encontrar animes.");

    if (args['paginator']) {
      const paginator = this.getPaginator(args['paginator']);
      paginatorHtml.innerHTML = paginator.pages;
      paginatorInfo.innerHTML = paginator.info;
    }

    theadElement.innerHTML = this.contentThead;

    tbodyElement.innerHTML = `
      ${this.createBodyTable(args['data'])}
    `;

  }

  clearTable() {
    this.content.innerHTML = '';
  }

  error(messageError) {
    const table = document.querySelector(`.${this.nameTable}_table`)
    let tbodyElement = this.tbodyElement();
    if (!table) {
      tbodyElement = false;
      this.content.appendChild(this.createTable('', ''));
      const tableElement = this.tableElement();
      tableElement.innerHTML = messageError;
    }
    const theadElement = this.theadElement();
    const paginatorHtml = this.paginatorHtml();
    const paginatorInfo = this.paginatorInfo();

    if (paginatorHtml) paginatorHtml.innerHTML = '';
    if (paginatorInfo) paginatorInfo.innerHTML = '';
    if (theadElement) theadElement.innerHTML = '';
    if (tbodyElement) tbodyElement.innerHTML = messageError;
    return;
  }
}