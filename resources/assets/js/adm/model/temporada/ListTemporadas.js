import {List} from "../List.js";

export class ListTemporadas extends List {
  constructor() {
    super();
  }

  push(element) {
    this.list.push(new Temporada(element.id, element.name, element.number,element.animeId))
  }
}