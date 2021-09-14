import {TableView} from "../Utils/Table.js";

export class TemporadaView {
  constructor(name) {
    this.tableView = new TableView(name);
    this.content = document.querySelector('.table');
  }


}