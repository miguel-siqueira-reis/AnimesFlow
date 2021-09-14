import{Service}from "./Service.js";export class TemporadaService extends Service{constructor(){super('localhost:8080/api/temporadas')}
async getByPage(page,limit){return await this.get(`?page=${page}&limit=${limit}`)}
async getAll(){return await this.get()}
async getById(id,page=!1,limit=!1){return await this.paginator('/'+id,page,limit)}}