import { ListAnimes } from '../model/animes/ListAnimes.js';
import { AnimesView } from '../view/AnimesView.js';
import { AnimeService } from '../services/AnimeService.js'
import {TemporadaController} from "./TemporadaController.js";
import {TableUtils} from "../Utils/Table.js";

export class AnimeController {
  constructor() {
    this.listAnimes = new ListAnimes();
    this.animesView = new AnimesView('animes');
    this.animeService = new AnimeService();
    this.table = new TableUtils('animes', this.listAnimes, this.animeService, this.animesView);
  }




  async createAnimeTable() {
    await this.table.createTable();

    await this.table.eventLimit();
    await this.table.eventPages();
    await this.table.eventSearch();

    await this.table.eventClick(id => {
      this.temp = new TemporadaController(id);
      this.temp.createTempTable();
    });
  }
}