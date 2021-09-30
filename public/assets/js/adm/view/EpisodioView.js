import{TableView}from "../Utils/Table/TableView.js";export class EpisodioView extends TableView{constructor(tableName){super(tableName,!0,!0)}
template(args){if(!args.data[0])return this.error(args.error||'não foi encontrado nenhum episodios.');const has=document.querySelector(`.${this.nameTable}_table`);if(has){const parent=has.parentNode;parent.removeChild(has)}
const paginator=this.getPaginator(args.paginator);const episodios=args.data;const tbody=this.createBodyTable(episodios);const thead=this.createThead(['id','Name','number','watch','actions'])
const node=this.createTable(thead,tbody,paginator);this.content.appendChild(node)}
createBodyTable(episodios){if(!episodios[0])episodios=[episodios];let episodioHtml='';episodios.forEach(episodio=>{episodioHtml+=this.createTbody([episodio.id,episodio.name,episodio.number,episodio.watch,this.createAction([{name:'<i class="fas fa-edit"></i>',link:'/episodio/edit/'+episodio.id},{name:'<i class="fas fa-trash-alt"></i>',link:'/episodio/destroy/'+episodio.id}])],{id:episodio.id,id_temporada:episodio.id_temporada})})
return episodioHtml}}