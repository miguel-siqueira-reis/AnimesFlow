import {TableUtils} from "../Utils/Table.js";
import {ListTemporadas} from "../model/temporada/ListTemporadas.js";
import {TemporadaService} from "../services/TemporadaService.js";
import {TemporadaView} from "../view/TemporadaView.js";

export class TemporadaController {
  constructor(id) {
    this.animeId = id;
    this.listTemp = new ListTemporadas();
    this.tempService = new TemporadaService();
    this.tempView = new TemporadaView('temporadas');
    this.table = new TableUtils('temporadas', this.listTemp, this.tempService, this.tempView);
  }

  async createTempTable() {
    await this.table.createById(this.animeId);
    await this.table.eventLimit();
    await this.table.eventPages();

  }
}