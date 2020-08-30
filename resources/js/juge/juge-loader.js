class jugeLoader{

  constructor(color = '#fff6003b;') {
    this.color = color;
    this.activeLoaders = [];
  }

  start(container = 'body'){
    let id = this.getFreeLoaderId();
    //Make dom
    let dom = this.appendDom(id,container);
    // Keep sizing
    let sizing = this.keepSizing(dom,container,id);    
    // Push loader 
    this.activeLoaders.push({id,dom,sizing});
    
    return id;
  }

  stop(id){
    //Get loader
    let i = this.activeLoaders.findIndex(x => x.id == id);
    let loader = this.activeLoaders[i];

    //stop sizing
    this.stopSizing(loader.sizing);

    //Remove dom
    loader.dom.remove();

    //remove var
    this.activeLoaders.splice(i,1);
  }

  getFreeLoaderId(){
    let i = 0;
    do {i++;} while ($('.juge-loader[data-id='+i+']').length > 0);
    return i;
  }

  appendDom(id,container){
    let height = $(container).outerHeight();
    let width = $(container).outerWidth();
    let margin ={
      top:    $(container).css('margin-top'),
      rigth:  $(container).css('margin-rigth'),
      bottom: $(container).css('margin-bottom'),
      left:   $(container).css('margin-left'),
    } 
    let border ={
      top:    $(container).css('border-top-width'),
      rigth:  $(container).css('border-rigth-width'),
      bottom: $(container).css('border-bottom-width'),
      left:   $(container).css('border-left-width'),
    } 
    let padding ={
      top:    $(container).css('padding-top'),
      rigth:  $(container).css('padding-rigth'),
      bottom: $(container).css('padding-bottom'),
      left:   $(container).css('padding-left'),
    } 
  
    $(container).append(''+
      '<div '+ 
        'class="juge-loader" '+
        'data-id="'+id+'"'+
        'style="'+
          'cursor: wait;'+
          'position:fixed;'+
          'top:'+(margin.top)+';'+
          'left:'+(margin.left)+';'+
          'width:'+(width)+'px;'+
          'height:'+(height)+'px;'+
          'background-color:'+this.color+';'+
          'z-index: 99999;'+
        '"'+
      '></div>'
    );

    return $('.juge-loader[data-id="'+id+'"]')
  }

  keepSizing(dom,container,id){
    return setInterval(()=>{
      dom.height($(container).outerHeight()); 
      dom.width($(container).outerWidth()); 
    }, 500);
  }

  stopSizing(id){
    clearInterval(id);    
  }




}

export default jugeLoader;