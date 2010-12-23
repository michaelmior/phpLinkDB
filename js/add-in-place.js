var aip = new Class({
	initialize: function(action, params, options) {
		this.action = action;
		this.params = params;
		
		this.options = Object.extend({
			addId: 'add'
		}, options || {} );
		
		var els = $$('#'+this.options.addId);
		
		if ($type(els) == 'array') {
			els.each(function(el) {
				this.prepAdd(el);
			}.bind(this));
		} else if ($type(els) == 'element') {
			this.prepAdd(els);
		} else {
			return;
		}
	},
	
	prepAdd: function(el) {
		var obj = this;
		el.addEvents({
			'click': function(){obj.addObj(this);}
		});
	},
	
	addObj: function(el) {
		var row = new Element('tr').setProperty('id', 'newrow_' + newID);
		
		document.getElementsByTagName('tbody')[0].appendChild(row);
		
		new Ajax(this.action, {method: 'post', update: $('newrow_'+newID), data: { action: this.params['action'] }}).request();
		
		newID++;
	}
});

newID = 0;