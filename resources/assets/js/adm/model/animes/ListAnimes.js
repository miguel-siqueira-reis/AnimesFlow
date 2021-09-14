import {List} from '../List.js';
import {Anime} from './Anime.js';

export class ListAnimes extends List {
  constructor() {
    super();
  }

  push(element) {
    this.list.push(new Anime(element.id, element.name, element.sinopse, element.classification, element.image, element.backgroundimage, element.studio, element.year, element.active))
  }
}
