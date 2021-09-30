import {TableUtilsController} from "../Utils/Table/TableUtilsController.js";
import {ListTemporadas} from "../model/temporada/ListTemporadas.js";
import {TemporadaService} from "../services/TemporadaService.js";
import {TemporadaView} from "../view/TemporadaView.js";
import {EpisodioController} from "./EpisodioController.js";

export class TemporadaController extends TableUtilsController {
  constructor(id = false) {
    super('temporadas', new ListTemporadas(), new TemporadaService(), new TemporadaView('temporadas'));
    this.animeId = id;
    this.ep = false;
  }

  async createTempTableById(id = this.animeId) {
    this.animeId = id;
    this.ep = new EpisodioController();
    this.ep.view.clearTable();
    await this.createById(this.animeId);
    await this.eventLimit();
    await this.eventPages();

    await this.eventClick((id) => {
      this.ep = new EpisodioController();
      this.ep.createEpTableById(id);
    }, 'id_anime');
  }
}