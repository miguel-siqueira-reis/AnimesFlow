import {TableView} from "../Utils/Table.js";

export class AnimesView {
  constructor(tableName) {
    this.tableView = new TableView(tableName, true, true);
    this.content = document.querySelector('.table');
  }

  template(args) {

    if (!args['data'][0]) return this.error(args['error']||'não foi encontrado nenhum anime.');

    const paginator = this.tableView.getPaginator(args['paginator']);

    const anime = args['data'];

    const tbody = this.createBodyTable(anime);

    const thead = this.tableView.createThead(['id', 'Name', 'Sinopse', 'classification', 'Studio', 'Year', 'Active', 'actions'])

    this.content.innerHTML += this.tableView.createTable(thead, tbody, paginator);
  }

  update(args) {
    this.tbodyElement = document.querySelector('.animes_table__content.body');
    this.paginatorHtml = document.querySelector('.animes__paginator__place');
    this.paginatorInfo = document.querySelector('.animes__info');

    this.tbodyElement.innerHTML = '';

    if (!args['data'][0]) return this.error(args['error']||"não foi posivel encontrar animes.");

    if (args['paginator']) {
      const paginator = this.tableView.getPaginator(args['paginator']);
      this.paginatorHtml.innerHTML = paginator.pages;
      this.paginatorInfo.innerHTML = paginator.info;
    }

    this.tbodyElement.innerHTML = `
      ${this.createBodyTable(args['data'])}
    `;

  }

  error(messageError) {
    if (this.paginatorHtml) this.paginatorHtml.innerHTML = '';
    if (this.paginatorInfo)this.paginatorInfo.innerHTML = '';
    if (this.tbodyElement) this.tbodyElement.innerHTML = messageError;
    return;
  }

  createBodyTable(animes) {
    if (!animes[0]) animes = [animes];
    let animeHtml = '';
    animes.forEach(anime => {
      animeHtml += this.tableView.createTbody([
        anime.id,
        anime.name,
        anime.sinopse,
        anime.classification,
        anime.studio,
        anime.year,
        anime.active === '1' ? 'active' : 'not Active',
        this.tableView.createAction([{name: '<i class="fas fa-edit"></i>', link: '/anime/edit/'+anime.id },{name: '<i class="fas fa-trash-alt"></i>', link: '/anime/destroy/'+anime.id}])
      ], true);
    })
    return animeHtml;
  }


}