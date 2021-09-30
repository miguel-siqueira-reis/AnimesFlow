import {List} from "../List.js";
import {Episodio} from "./Episodio.js";

export class ListEpisodios extends List {
  constructor() {
    super();
  }

  push(element) {
    this.list.push(new Episodio(element.id, element.name, element.number, element.image, element.watch, element.id_anime));
  }
}