import {TableView} from "../Utils/Table/TableView.js";

export class TemporadaView extends TableView {
  constructor(name) {
    super(name, true);
  }

  template(args) {
    if (!args['data'][0]) return this.error(args['error']||'não foi encontrado nenhuma temporada.');

    const has = document.querySelector(`.${this.nameTable}_table`);
    if (has) {
      const parent = has.parentNode;
      parent.removeChild(has);
    }

    const paginator = this.getPaginator(args['paginator']);

    const temporadas = args['data'];

    const tbody = this.createBodyTable(temporadas);

    const thead = this.createThead(['id', 'Numero da temporada', 'actions'])

    this.content.appendChild(this.createTable(thead, tbody, paginator));
  }

  createBodyTable(temporadas) {
    if (!temporadas[0]) temporadas = [temporadas];
    let temporadasHtml = '';
    temporadas.forEach(temporada => {
      temporadasHtml += this.createTbody([
        temporada.id,
        temporada.number,
        this.createAction([{name: '<i class="fas fa-edit"></i>', link: '/temporada/edit/'+temporada.id },{name: '<i class="fas fa-trash-alt"></i>', link: '/temporada/destroy/'+temporada.id}])
      ], {id: temporada.id, id_anime: temporada.id_anime});
    })
    return temporadasHtml;
  }
}