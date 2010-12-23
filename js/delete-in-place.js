var dip = new Class({
	initialize: function(els, action, params, options) {
		if ($type(els) == 'array') {
			els.each(function(el) {
				this.prepDelete(el);
			}.bind(this));
		} else if ($type(els) == 'element') {
			this.prepDelete(els);
		} else {
			return;
		}
		
		this.action = action;
		this.params = params;
		
		this.options = Object.extend({
			deletableCl: 'deletable'
		}, options || {} );
		
	},
	
	prepDelete: function(el) {
		var obj = this;
		el.addEvents({
			'click': function(){obj.deleteObj(this);}
		});
	},
	
	deleteObj: function(el) {
		if(!confirm("Really delete?")) {
			return;
		}
		
		var classes = el.getProperty('class').split(" ");
		for (i=classes.length-1;i>=0;i--) {
			if (classes[i].contains('item:')) {
				var target = classes[i].split(":")[1];
			} else if (classes[i].contains('id:')) {
				var id = classes[i].split(":")[1];
			}
		}
		
		var parent = el.getParent();
		var parentTag = parent.getTag();

		while(!parentTag.test('tr')) {
			parent = parent.getParent();
			parentTag = parent.getTag();
		}
	
		var form = new Element('form', {
			'id': 'form_' + el.getProperty('id'),
			'action': this.action,
			'class': this.options.deletableCl
		});
		
		el.form = form;
		
		for (param in this.params) {
			new Element('input', {
				'type': 'hidden',
				'name': param,
				'value': this.params[param]
			}).injectInside(form);
		}
		
		new Element('input', {
			'type': 'hidden',
			'name': 'id',
			'value': id
		}).injectInside(form);
		
		form.injectAfter(el);
		
		form.send({update: el});
		
		parent.remove();
	}
});