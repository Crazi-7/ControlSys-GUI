
example.Toolbar = Class.extend({
	
	init:function(elementId, app,view){
		this.html = $("#"+elementId);
		this.view = view;
		this.app = app;
		
		
		// Inject the zoomin
		//
		this.zoomInButton  = $("#zoom-in-button");
		this.zoomInButton.button().click($.proxy(function(){
		      this.view.setZoom(this.view.getZoom()*0.7,true);
		      this.app.layout();
		},this));

		// Inject the fit view Button
		//
		this.resetButton  = $("#fit-button");
		this.resetButton.button().click($.proxy(function(){
		    this.view.setZoom(1.0, true);
            this.app.layout();
		},this));
		
		// Inject the zoombout Button and the callback
		//
		this.zoomOutButton  = $("#zoom-out-button");
		this.zoomOutButton.button().click($.proxy(function(){
            this.view.setZoom(this.view.getZoom()*1.3, true);
            this.app.layout();
		},this));

        view.getCommandStack().addEventListener(this);

		// Register a Selection listener for the state hnadling
		// of the Delete Button
		//
        view.on("select", $.proxy(this.onSelectionChanged,this));
		
		// Inject the UNDO Button and the callbacks
		//
				this.undoButton  = $("#undo-button");
				this.undoButton.button().click($.proxy(function(){
					this.view.getCommandStack().undo();
				},this)).button( "option", "disabled", true );

		// Inject the REDO Button and the callback
		//
				this.redoButton  = $("#redo-button");
			
				this.redoButton.button().click($.proxy(function(){
					this.view.getCommandStack().redo();
				},this)).button( "option", "disabled", true );
				

		// Inject the DELETE Button
		//
				this.deleteButton  = $("#delete-button");
				
				this.deleteButton.button().click($.proxy(function(){
					var node = this.view.getPrimarySelection();
					var command= new draw2d.command.CommandDelete(node);
					this.view.getCommandStack().execute(command);
				},this)).button( "option", "disabled", true );
	},

    	/**
	 * @method
	 * Called if the selection in the cnavas has been changed. You must register this
	 * class on the canvas to receive this event.
	 *
     * @param {draw2d.Canvas} emitter
     * @param {Object} event
     * @param {draw2d.Figure} event.figure
	 */
	onSelectionChanged : function(emitter, event){
		this.deleteButton.button( "option", "disabled", event.figure===null );
	},
	
	/**
	 * @method
	 * Sent when an event occurs on the command stack. draw2d.command.CommandStackEvent.getDetail() 
	 * can be used to identify the type of event which has occurred.
	 * 
	 * @template
	 * 
	 * @param {draw2d.command.CommandStackEvent} event
	 **/
	stackChanged:function(event)
	{
		this.undoButton.button( "option", "disabled", !event.getStack().canUndo() );
		this.redoButton.button( "option", "disabled", !event.getStack().canRedo() );
	}
});
