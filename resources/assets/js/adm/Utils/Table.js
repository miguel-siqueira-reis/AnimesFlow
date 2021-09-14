export class TableUtils {
  constructor(tableName, list, service, view, defaultPage= 1, defaultLimit = 1) {
    this.tableName = tableName;
    this.view = view;
    this.list = list;
    this.service = service;
    this.page = defaultPage;
    this.limit = defaultLimit;
    this.json = false;
    this.searchText = false;
    this.classEventPages = false;
    this._propsTemplate = {};
  }

  async connection() {
    if (this.searchText) {
      await this.connectionBySearch();
      return;
    }
    if (this.id) {
      await this.connectionById();
      return;
    }
    this.json = await this.service.getByPage(this.page, this.limit) || false;
    this.list.set(this.json['data'] || false);

  }

  async connectionBySearch() {
    this.json = await this.service.search(this.searchText, this.page, this.limit) || false;
    this.list.set(this.json['data'] || false);
  }

  async connectionById() {
    this.json = await this.service.getById(this.id, this.page, this.limit);
    this.list.set(this.json['data'] || false);
  }

  async createTable() {
    await this.connection();
    await this.view.template(this.getPropsTemplate());
  }

  async createById(id) {
    this.id = id;
    await this.createTable();

  }

  async updateTable() {
    await this.connection();
    await this.view.update(this.getPropsTemplate());
    if (this.classEventPages) await this.eventPages(this.classEventPages);
  }


  async eventLimit() {
    const limit = document.querySelector('#'+this.tableName+'Limit');
    limit.addEventListener('change', async e => {
      this.limit = e.target.value;
      await this.updateTable();
    })
  }

  async eventPages() {
    this.classEventPages = true;
    const pages = document.querySelectorAll('.'+this.tableName+'__paginator');
    pages.forEach(page => {
      page.addEventListener('click', async e => {
        this.page = e.target.dataset.page;
        pages.forEach(e => e.classList.remove('active'))
        e.target.classList.add('active');
        await this.updateTable();
      })
    })
  }

  async eventSearch() {
    const search = document.querySelector('#'+this.tableName+'Search');
    search.addEventListener('input', async e => {
      this.searchText = e.target.value;
      await this.updateTable();
    })
  }

  propsTemplatePush(prop) {
    this._propsTemplate = Object.assign(prop, this._propsTemplate);
  }

  getPropsTemplate(){
    return Object.assign({ data: this.list.getAll(), paginator: this.json['paginator'] }, this._propsTemplate);
  }

  eventClick(callback) {
    const dataArr = document.querySelectorAll(`.${this.tableName}__tr.content`);

    dataArr.forEach(data => {
      data.addEventListener('click', e => {
        let id = e.target.dataset.id;

        if (id === undefined) id = e.target.parentNode.dataset.id;
        if (!id) return;

        return callback(id);
      })
    })
  }
}






export class TableView {
  constructor(nameTable, limit=false, search=false) {
    this.nameTable = nameTable;
    this.capitalized = this.nameTable[0].toUpperCase() + this.nameTable.substr(1);
    this.selectId = limit ? this.nameTable+'Limit' : false;
    this.searchId = search ? this.nameTable+'Search' : false;
  }

  createTable(thead, tbody, paginator = false) {
    return `
      <div class="${this.nameTable}_table">
      <div class="${this.nameTable}_table__title"><i class="fas fa-table"></i> Table ${this.capitalized}</div>
      <div class="${this.nameTable}_table__content">
        <div class="${this.nameTable}_table__content__top">
          ${this.select() || ''}
          ${this.search() || ''}
        </div>
        <div class="${this.nameTable}_table__content__midle">
          <table class="${this.nameTable}_table__content__midle__table table">
            <thead class="${this.nameTable}_table__content__midle__table__thead thead">
              ${thead}
            </thead>
            <tbody class="${this.nameTable}_table__content__midle__table__tbody body ${this.nameTable}_table__content">
              ${tbody}
            </tbody>
          </table>
        </div>
        <div class="${this.nameTable}_table__content__bottom">
          ${this.paginator(paginator) || ''}
      </div>
    </div>
    `;
  }

  createTbody(tbody, id= false) {
    let tds = '';
    let dataId = false;

    if (id) dataId = tbody[0];

    tbody.forEach(elementTd => {
      tds += `
        <td class="${this.nameTable}__td td">${elementTd}</td>
      `;
    })

    return `
      <tr data-id="${dataId||false}" class="${this.nameTable}__tr tr content">
        ${tds}
      </tr>
    `;
  }

  createThead(arrayTd) {
    let ths = '';

    arrayTd.forEach(elementTh => {
      ths += `
        <th class="${this.nameTable}_table__content__midle__table__thead_th th ${this.nameTable}__th">${elementTh}</th> 
      `;
    })

    return `
      <tr class="tr ${this.nameTable}__tr">
        ${ths}
      </tr>
    `;
  }


  select() {
    if (!this.selectId) return '';

    return `
      <div class="${this.nameTable}_table__content__top__limit">
        <label for="select_limit_${this.nameTable}_table">
          <select id="${this.selectId}" class="${this.nameTable}_table__content__top__limit__select">
          <option value="1">1</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="25">25</option>
          </select>
           entries per page
        </label>
      </div>
    `;
  }

  search() {
    if (!this.searchId) return '';

    return `
      <div class="${this.nameTable}_table__content__top__search">
        <input id="${this.searchId}" type="text" placeholder="Search...">
      </div>
    `;
  }

  paginator(paginator) {
    if (!paginator) return '';
    return `
      <div class="info ${this.nameTable}__info">${paginator.info}</div>
          <div class="${this.nameTable}_table__content__bottom__paginator">
            <div class="paginator ${this.nameTable}__paginator__place">
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
        actionlet += `<a href="${action.link}" class="${this.nameTable}__action btn">${action.name}</a>`;
      })
      return actionlet;
    }
    return `<a href="${actions.link}" class="${this.nameTable}__action btn">${actions.name}</a>`;

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
      info: `<div class="${this.nameTable}_table__content__bottom__info">Showing ${paginator['limit']} to ${paginator['current_page']} of ${paginator['total']} entries</div>`
    }
  }
}