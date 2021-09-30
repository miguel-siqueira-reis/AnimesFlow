import {TableView} from "../Utils/Table/TableView.js";

export class AnimesView extends TableView {
  constructor(tableName) {
    super(tableName, true, true);
  }

  template(args) {

    if (!args['data'][0]) return this.error(args['error']||'não foi encontrado nenhum anime.');

    const has = document.querySelector(`.${this.nameTable}_table`);

    if (has) {
      const parent = has.parentNode;
      parent.removeChild(has);
    }

    const paginator = this.getPaginator(args['paginator']);

    const anime = args['data'];

    const tbody = this.createBodyTable(anime);

    const thead = this.createThead(['id', 'Name', 'Sinopse', 'classification', 'Studio', 'Year', 'Active', 'actions'])

    const node = this.createTable(thead, tbody, paginator);

    this.content.appendChild(node);
  }

  createBodyTable(animes) {
    if (!animes[0]) animes = [animes];
    let animeHtml = '';
    animes.forEach(anime => {
      animeHtml += this.createTbody([
        anime.id,
        anime.name,
        anime.sinopse,
        anime.classification,
        anime.studio,
        anime.year,
        anime.active === '1' ? 'active' : 'not Active',
        this.createAction([{name: '<i class="fas fa-edit"></i>', link: '/anime/edit/'+anime.id },{name: '<i class="fas fa-trash-alt"></i>', link: '/anime/destroy/'+anime.id}])
      ], {id: anime.id});
    })
    return animeHtml;
  }
}