function addComponent(item)
    {
        
       var color;
        switch(item.currentTarget.childNodes[3].className.substr(25)) 
        {
            case "sources":
                // sources
                color = "#41a7eb";
                break;
            case "functionsy":
                //functions
                color = "#4ae159";
                break;
            default:
                //sinks
                color = "#ded74e";
        }
        
        var LabelRectangle= draw2d.shape.basic.Rectangle.extend({
            init:function(attr)
            {
                this._super(attr);
                var show=function(){this.setVisible(true);};
                var hide=function(){this.setVisible(false);};

                switch(item.currentTarget.childNodes[3].className.substr(25)) {
                    case "sources":
                        // sources
                        var output= this.createPort("output");
                        break;
                    case "functionsy":
                        //functions
                        var input = this.createPort("input");
                        input.on("connect",hide,input);
                        input.on("disconnect",show,input);

                        var output= this.createPort("output");
                        break;
                    default:
                        //sinks
                        var input = this.createPort("input");
                        input.on("connect",hide,input);
                        input.on("disconnect",show,input);
                }
                if (item.currentTarget.childNodes[3].innerHTML == "Adder")
                {
                    var input = this.createPort("input");
                    input.on("connect",hide,input);
                    input.on("disconnect",show,input);
                }
                // Create any Draw2D figure as decoration for the connection
                this.label = new draw2d.shape.basic.Label({text:item.currentTarget.childNodes[3].innerHTML, color:color, fontColor:"#0d0d0d"});
                // add the new decoration to the connection with a position locator.
                this.add(this.label, new draw2d.layout.locator.CenterLocator(this));
                this.label.installEditor(new draw2d.ui.LabelInplaceEditor());
            }
        })
        var rect = new LabelRectangle({width:100, height:80,bgColor: color, radius: 10});
        app.view.add(rect, 150+Math.random()*150,150+Math.random()*100);
    }