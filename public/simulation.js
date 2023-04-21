function render(numerator, denominator, button, destination) {
 
    var num = document.getElementById(numerator).value.trim();
    var den = document.getElementById(denominator).value.trim();
    var numlength = num.length/2;
    var i = 0;

    if (num.length == 0)
        num = "1";

    if (den.length == 0)
        den = "1";

    var numval= [];
    while (num.indexOf(" ") != -1)
    {
        numval[i] = parseInt(num);
        num = num.slice(num.indexOf(" "));    
        num = num.trimStart();   
        i++;
    }
    numval[i] = parseInt(num);
    
    var denlength = den.length/2;
    i = 0;
    var denval= [];
    while (den.indexOf(" ") != -1)
    {
        denval[i] = parseInt(den);
        den = den.slice(den.indexOf(" "));    
        den = den.trimStart();
        i++
    }
    denval[i] = parseInt(den);
    
    numval = numval.reverse();
    denval = denval.reverse();
    nums = [... numval];
    dens = [... denval];
    var input = "";
    
    for (var j=numval.length-1;j>=0;j--)
    {
        var extra = "";
        var sign = "+";
        if (numval[j] == 0)
        input = input.slice(0, input.length - 1);
        else if (j > 1)
        {
            if (numval[j-1] < 0)
            {
                sign = "-";
                numval[j-1] = Math.abs(numval[j-1]);
            } else
            sign = "+";
            input += numval[j] + "s^" + j + sign;
        }
        else if (j>0)
        {
            if (numval[j-1] < 0)
            {
                sign = "-";
                numval[j-1] = Math.abs(numval[j-1]);
            } else
            sign = "+";
            input += numval[j] + "s" + sign;
        }
        else
        input += numval[j];
    }
    
    input += "\\over ";

    for (var j=denval.length-1;j>=0;j--)
    {
        var extra = "";
        var sign = "+";
        if (denval[j] == 0)
        input = input.slice(0, input.length - 1);
        else if (j > 1)
        {
            if (denval[j-1] < 0)
            {
                sign = "-";
                denval[j-1] = Math.abs(denval[j-1]);
            } else
            sign = "+";
            input += denval[j] + "s^" + j + sign;
        }
        else if (j>0)
        {
            if (denval[j-1] < 0)
            {
                sign = "-";
                denval[j-1] = Math.abs(denval[j-1]);
            } else
            sign = "+";
            input += denval[j] + "s" + sign;
        }
        else
        input += denval[j];
    }
    var button = document.getElementById(button);
   // button.disabled = true;

    output = document.getElementById(destination);
    output.innerHTML = '';

    MathJax.texReset();
    var options = MathJax.getMetricsFor(output);
    MathJax.tex2chtmlPromise(input, options).then(function (node) {
    output.appendChild(node);
    MathJax.startup.document.clear();
    MathJax.startup.document.updateDocument();
     }).catch(function (err) {
    output.appendChild(document.createElement('pre')).appendChild(document.createTextNode(err.message));
    }).then(function () {
    button.disabled = false;
    });
 }   