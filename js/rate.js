
window.addEvent('domready',function(){

  var Tips3 = new Tips($$('.toolTipImg'), {
  initialize:function(){
		this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0.9);
	},
	showDelay: 400,
	hideDelay: 200,
	fixed: false
});

$$('.toolTipImg').addEvent('click',function(event){
	event = new Event(event).stop();
	var id = this.getAttribute('id');
	var rel = this.getAttribute('rel');	
	new Ajax('vote.php?id='+id+'&value='+rel, { method:'get', data:this, evalScripts:true }).request();
	return false;
})
})
