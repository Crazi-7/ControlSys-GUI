var DblClickCanvasPolicy = draw2d.policy.canvas.CanvasPolicy.extend({

    init : function()
    {
        this._super();
    },
    
    /**
     * @method
     * Called by the canvas if the user double click on a figure.
     *
     * @param {draw2d.Figure} the figure under the double click event. Can be null
     * @param {Number} mouseX the x coordinate of the mouse during the click event
     * @param {Number} mouseY the y coordinate of the mouse during the click event
     * @param {Boolean} shiftKey true if the shift key has been pressed during this event
     * @param {Boolean} ctrlKey true if the ctrl key has been pressed during the event
     *
     */
    onDoubleClick: function(figure, mouseX, mouseY, shiftKey, ctrlKey)
    {
        if(figure!==null) {
            console.log(figure.cssClass);
            if (figure.cssClass != "draw2d_Connection" && figure.cssClass != "draw2d_InputPort" && figure.cssClass != "draw2d_OutputPort") //only displace blocks
            {
                
                if (document.getElementsByClassName("sidebar")[0].classList.length == 2) //if sidebar is not shown
                {
                    toggleEdit();
                }
                   
                    if(document.getElementsByClassName("tool")[3].classList[2] == "clicked") //if sidebar is shown
                    {
                        const editButton = document.getElementsByClassName("tool")[2];
                        editButton.classList.add("clicked");
                        const addbar = document.getElementsByClassName("add-bar")[0];
                        addbar.classList.add("hidden");
                        const editbar = document.getElementsByClassName("edit-bar")[0];
                        editbar.classList.remove("hidden");
                        const editButton2 = document.getElementsByClassName("tool")[3];
                        editButton2.classList.remove("clicked");
                    } 
                
            }
        }
    }
    });