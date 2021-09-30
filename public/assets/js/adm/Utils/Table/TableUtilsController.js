import{Hash}from "../url/Hash.js";export class TableUtilsController{constructor(tableName,list,service,view,defaultPage=1,defaultLimit=1){this.hash=new Hash(tableName);this.tableName=tableName;this.view=view;this.list=list;this.service=service;this.page=this.hash.getPage()||defaultPage;this.limit=this.hash.getLimit()||defaultLimit;this.json=!1;this.searchText=this.hash.getSearchText();this.classEventPages=!1;this._propsTemplate={};this.callbackEventClick=!1;this.validations={};this.error=!1}
async connection(){if(this.searchText){await this.connectionBySearch();return}
if(this.id){await this.connectionById();return}
this.json=await this.service.getByPage(this.page,this.limit)||!1;this.list.set(this.json.data||!1);this.error=this.json.error}
async connectionBySearch(){this.json=await this.service.search(this.searchText,this.page,this.limit)||!1;this.list.set(this.json.data||!1);this.error=this.json.error}
async connectionById(){this.json=await this.service.getById(this.id,this.page,this.limit);this.list.set(this.json.data||!1);this.error=this.json.error}
async createTable(){await this.connection();await this.view.template(this.getPropsTemplate())}
async createById(id){this.id=id;await this.createTable()}
async updateTable(){await this.connection();await this.view.update(this.getPropsTemplate());if(this.classEventPages){await this.eventPages(this.classEventPages);this.callbackEventClick?await this.eventClick(this.callbackEventClick):!1}}
async eventLimit(){const limit=document.querySelector('#'+this.tableName+'Limit');const options=document.querySelectorAll('.'+this.tableName+'__option');let foundOption=options[0];options.forEach(option=>{if(option.value==this.limit){foundOption=option}})
foundOption.setAttribute('selected','selected');limit.addEventListener('change',async e=>{this.hash.setLimit(e.target.value);this.limit=this.hash.getLimit();await this.updateTable()})}
async eventPages(){this.classEventPages=!0;const pages=document.querySelectorAll('.'+this.tableName+'__paginator');pages.forEach(page=>{page.addEventListener('click',async e=>{this.hash.setPage(e.target.dataset.page);this.page=this.hash.getPage();pages.forEach(e=>e.classList.remove('active'));e.target.classList.add('active');await this.updateTable()})})}
async eventSearch(){const search=document.querySelector('#'+this.tableName+'Search');search.addEventListener('input',async e=>{this.hash.setSearchText(e.target.value);this.searchText=this.hash.getSearchText();await this.updateTable()})
if(this.searchText){search.value=this.searchText;console.log('oi')}}
propsTemplatePush(prop){this._propsTemplate=Object.assign(prop,this._propsTemplate)}
getPropsTemplate(){return Object.assign({data:this.list.getAll()||this.error,paginator:this.json.paginator},this._propsTemplate)}
eventClick(callback,prop='id'){this.callbackEventClick=callback;this.prop=prop;const dataArr=document.querySelectorAll(`.${this.tableName}__tr.content`);dataArr.forEach(data=>{data.addEventListener('click',e=>{let propElement=e.target.dataset[this.prop];if(!this.prop||!this.callbackEventClick)return;if(propElement===undefined)propElement=e.target.parentNode.dataset[this.prop];if(!propElement)return;this.hash.setEventClick(propElement);return this.callbackEventClick(propElement)})})
if(this.hash.getEventClick()!==!1)this.callbackEventClick(this.hash.getEventClick())}}