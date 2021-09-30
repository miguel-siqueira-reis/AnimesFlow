import { ListAnimes } from '../model/animes/ListAnimes.js';
import { AnimesView } from '../view/AnimesView.js';
import { AnimeService } from '../services/AnimeService.js'
import {TemporadaController} from "./TemporadaController.js";
import {TableUtilsController} from "../Utils/Table/TableUtilsController.js";

export class AnimeController extends TableUtilsController {
  constructor() {
    super('animes', new ListAnimes(), new AnimeService(), new AnimesView('animes'));
  }

  async createAnimeTable() {
    await this.createTable()

    await this.eventLimit();
    await this.eventPages();
    await this.eventSearch();

    await this.eventClick(id => {
      this.temp = new TemporadaController();
      this.temp.createTempTableById(id);
    });
  }
}