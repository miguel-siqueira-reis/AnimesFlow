export class List{constructor(){this.list=[]}
add(element){if(element[0]){const arr=element;arr.forEach(element=>{this.push(element)})
return}
this.push(element)}
getAll(){return[].concat(this.list)}
clear(){this.list=[]}
push(element){this.list.push(element)}
set(array){if(typeof(array)!==typeof([])||typeof(array)!==typeof({})){this.list=[];return}
this.list=array}}