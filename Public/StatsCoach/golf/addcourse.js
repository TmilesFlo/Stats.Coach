var tee_boxes,
    Handicap_number,
    total_holes = 18, tee_box_colors = [];

$(document).on('submit', 'form[data-pjax]', function (event) {
    event.preventDefault();
    document.getElementById('hole-18-distances').style.display = "none";
    $.pjax.submit(event, '#ajax-content')
});

$(function () {
    $(".select2").select2();       //Initialize Select2 Elements
    $("[data-mask]").inputmask();  //Money Euro
});

function hasDuplicates(array) {
    return (new Set(array)).size !== array.length;
}

function HideMeShow(hide, show) {
    if (hide != null) document.getElementById(hide).style.display = "none";
    if (show != null) document.getElementById(show).style.display = "block";
}

/* validate course data <int> */
function validateGeneral() {
    var Form = document.forms["addCourse"];
    var fields = ["c_name", "c_access", "c_style", "c_street", "c_city", "c_state", 'tee_boxes', 'Handicap_number'],
        lengthF = fields.length, e = false;

    for (var i = 0; i < lengthF; i++) {
        if (Form[fields[i]].value == null || Form[fields[i]].value == "") {
            $("#" + fields[i]).removeClass("has-success").addClass("has-error");
            e = true;
        } else $("#" + fields[i]).removeClass("has-error").addClass("has-success");
    }
    if (e) {
        return alert("Please Fill All Required Field");
    }

    tee_boxes = Form[fields[6]].value;
    Handicap_number = Form[fields[7]].value;
    new_tee_box_color_input();
    return HideMeShow('CourseInfo', 'Tee-Box-Color-Section'); // on success
}

function addColor(number, color) {
    var input = 'tee_' + number + '_color'; // To ensure they at least search for it
    tee_box_colors[number - 1] = color;
    document.getElementById(input).disabled = false;
    document.getElementById(input).setAttribute('value', color);
    document.getElementById(input).setAttribute("style", "background-color: " + color + ";")
}

function new_tee_box_color_input() {
    var container = document.getElementById('teebox-color-selection'),
        node = document.createElement("DIV"), current_hole = 1;
    container.innerHTML = null;
    do {
        var html =
            "<!-- Add Tee Box Selection --><div id='tee-box-color-"+current_hole+"' style='display:"+(current_hole === 1 ? 'block' : 'none')+";'><div class='box box-success' id='Tee-Box-Color-Section'style='background-color: #2c3b41; color: ghostwhite !important;'><div class='box-header with-border' style='width: 100%; text-align: center'><h3 class='box-title' style='font-size: 200%; color: #ffffff;'>Tee Box Color Selection</h3></div> \
                <div class='box-body' style='background-color: #2c3b41; color: ghostwhite !important;'> <h3>Tee Box " + current_hole + " Color</h3> \
                <div class='row col-lg-12 col-md-12'><div id='color-tee-box-selection' class='input-group input-group-lgsd'> \
                <div class='input-group-btn '><button type='button' class='btn dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>      Color Select    <span class='fa fa-caret-down'></span></button><ul class='dropdown-menu'> \
                <li><a onclick='addColor(" + current_hole + ", this.innerHTML)'>Blue</a></li><li><a onclick='addColor(" + current_hole + ", this.innerHTML)'>Black</a></li> \
                <li><a onclick='addColor(" + current_hole + ", this.innerHTML)'>Green</a></li><li><a onclick='addColor(" + current_hole + ", this.innerHTML)'>Gold</a></li> \
                <li><a onclick='addColor(" + current_hole + ", this.innerHTML)'>Red</a></li><li><a onclick='addColor(" + current_hole + ", this.innerHTML)'>White</a></li>";


        var h2 =
            "</ul></div><input id='tee_"+ current_hole +"_color' name='tee_" + current_hole + "_color' type='text' class='form-control' disabled></div></div><br><br><br><br><div class='row'><div class='col-md-6 col-sm-6'> \
                <div class='col-xs-6 col-md-6 text-center'><input name='general_difficulty_"+ current_hole +"' type='text' class='knob' value='0' data-step='0.1' data-min='0' data-max='90' data-anglearc='250' data-angleoffset='145' data-width='90' data-height='90' data-fgcolor='#3c8dbc' style='width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;'></div> \
                <div class='col-xs-6 col-md-6 text-center'><input name='general_slope_"+current_hole+"' type='text' class='knob' value='0' data-min='0' data-max='200' data-anglearc='250' data-angleoffset='-35' data-width='90' data-height='90' data-fgcolor='#f56954' style='width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;'> \
                </div><div class='col-xs-12 col-md-12'><div class='knob-label' style='color: #fff;'>General<br>Difficulty / Slope</div></div></div> \
                <div class='col-md-6 col-sm-6'><div class='col-xs-6 col-md-6 text-center'><input name='women_difficulty_"+current_hole+"' type='text' class='knob' value='0' data-step='0.1' data-min='0' data-max='90' data-anglearc='250' data-angleoffset='145' data-width='90' data-height='90' data-fgcolor='#00a65a' style='width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;'></div> \
                <div class='col-xs-6 col-md-6 text-center'><input name='women_slope_"+current_hole+"'type='text' class='knob' value='0' data-min='0' data-max='200' data-anglearc='250' data-angleoffset='-35' data-width='90' data-height='90' data-fgcolor='#00c0ef' style='width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 192, 239); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;'> \
                </div><div class='col-xs-12 col-md-12'><div class='knob-label' style='color: #fff;;'>Women\'s<br>Difficulty / Slope</div></div></div></div><!-- ./col -->";

        var back =
            "<button type='button' class='btn btn-default' onclick=\"HideMeShow('tee-box-color-"+current_hole+"','"+(current_hole == 1 ? 'CourseInfo' : ('tee-box-color-'+(current_hole-1)))+"')\"><< Back</button>";

        var next =
            "<button type='button' class='btn btn-info pull-right' onclick='"+(current_hole != 18 ? 'validate_tee_box_colors(\"'+current_hole+'\")' : null)+"'>Next >></button></div></div>";

        node.innerHTML =  html + h2 + back + next;
        container.innerHTML += node.innerHTML;
    } while (current_hole++ < tee_boxes);

    bootstrapAlert("Tee boxes difficulty and slope maybe left at 0 if not set.", "info");

    $(".select2").select2();
    $(".knob").knob({
        /*change : function (value) {
         //console.log("change : " + value);
         },
         release : function (value) {
         console.log("release : " + value);
         },
         cancel : function () {
         console.log("cancel : " + this.value);
         },*/
        draw: function () {

            // "tron" case
            if (this.$.data('skin') == 'tron') {

                var a = this.angle(this.cv)  // Angle
                    , sa = this.startAngle          // Previous start angle
                    , sat = this.startAngle         // Start angle
                    , ea                            // Previous end angle
                    , eat = sat + a                 // End angle
                    , r = true;

                this.g.lineWidth = this.lineWidth;

                this.o.cursor
                && (sat = eat - 0.3)
                && (eat = eat + 0.3);

                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.value);
                    this.o.cursor
                    && (sa = ea - 0.3)
                    && (ea = ea + 0.3);
                    this.g.beginPath();
                    this.g.strokeStyle = this.previousColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
    });

}


function validate_tee_box_colors(current) {
    if (hasDuplicates(tee_box_colors) || tee_box_colors.length == 0) {
        return alert("Sorry, you must enter all colors with no duplicates.");
    }

    if (tee_box_colors.length != tee_boxes && current != tee_boxes) {
        return HideMeShow("tee-box-color-"+current , "tee-box-color-"+(++current));
    }

    distance_box_generate();
    document.getElementById("tee-box-color-"+current).style.display = "none";
    document.getElementById('hole-1-distances').style.display = "block";
}

function validateDistance(current_hole) {
    var Form = document.forms["addCourse"], input;

    input = "par_" + current_hole;
    input = Form[input].value;
    if (input < 1 || input > 12)
        return alert("Sorry, your par should be between 1 and 12 inclusively.");

    for (var i = 0; i < tee_boxes; i++) {
        input = "tee_" + (i + 1) + "_" + current_hole;
        input = Form[input].value;
        if (input < 1 || input > 3000)
            return alert("Sorry, your input for tee box " + (i + 1) + " should be between 1 and 3,000 inclusively.");
    }
    for (i = 0; i < Handicap_number; i++) {
        input = "hc_" + (i + 1) + "_" + current_hole;
        input = Form[input].value;
        if (input < 1 || input > 18)
            return alert("The handicap value(s) must be a valid integer between 1 and 18 inclusively.")
    }
    HideMeShow('hole-' + current_hole + '-distances', 'hole-' + (++current_hole) + '-distances');
}

function distance_box_generate() {
    var container = document.getElementById('Tee_box_distances'),
        node = document.createElement("DIV"),
        current_hole = 1, box_color_input;
    container.innerHTML = null;
    do {
        box_color_input = document.createElement("DIV");

        // Tee box 1 , 2?
        for (i = 0; i < (tee_boxes < 2 ? tee_boxes : 2); i++)
            box_color_input.innerHTML +=
                '<div class="col-xs-12 col-sm-6 col-md-3 text-center"><div style="display:inline;width:180px;height:180px;">' +
                '<input name="tee_' + (i + 1) + '_' + current_hole + '" type="text" class="knob" value="1" data-min="1" data-max="1000" data-width="180" data-height="180" data-fgcolor="' + tee_box_colors[i] + '" ' +
                'style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;"> ' +
                '</div><div class="knob-label" style="color: white;">' + tee_box_colors[i] + '\'s Distance</div></div>';


        //'<input class="form-control input-lg" name="tee_' + (i + 1) + '_' + current_hole + '" min="1" max="3000" type="number" placeholder="' + tee_box_colors[i] + '\'s Hole #' + current_hole + ' Distance" style="text-align: center; border-color: ' + tee_box_colors[i] + '; display: inherit"><br>';

        // handicap 1 ?
        for (var i = 0; i < (Handicap_number < 1 ? Handicap_number : 1 ); i++)
            box_color_input.innerHTML +=
                '<div class="col-xs-12 col-sm-6 col-md-3 text-center centered"><div style="display:inline;width:180px;height:180px;">' +
                '<input name="hc_' + (i + 1) + '_' + current_hole + '" type="text" class="knob" value="1" data-min="1" data-max="18" data-width="180" data-height="180" data-fgcolor="teal" ' +
                'style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;"> ' +
                '</div><div class="knob-label" style="color: white;">Handicap</div></div>';


        //'<input class="form-control input-lg" name="hc_' + (i + 1) + '_' + current_hole + '" min="1" max="18" type="number" placeholder="Handicap ' + (i + 1) + '" style="text-align: center; display: inherit"><br>';

        // PAR
        box_color_input.innerHTML +=
            '<div class="col-xs-12 col-sm-6 col-md-3 text-center centered"><div style="display:inline;width:180px;height:180px;">' +
            '<input name="par_' + current_hole + '" type="text" class="knob" value="1" data-min="1" data-max="9" data-width="180" data-height="180" data-fgcolor="yellow" ' +
            'style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;"> ' +
            '</div><div class="knob-label" style="color: white;">Par ' + current_hole + '</div></div>';


        //'<input class="form-control input-lg" name="par_' + current_hole + '" min="1" max="12" type="number" placeholder="Hole #' + current_hole + ' Par" style="text-align: center; display: inherit"><br>';

        // Tee box 3 - 4 - 5 ?
        for (i = 2; i < tee_boxes; i++)
            box_color_input.innerHTML +=
                '<div class="col-xs-12 col-sm-6 col-md-3 text-center centered"><div style="display:inline;width:180px;height:180px;">' +
                '<input name="tee_' + (i + 1) + '_' + current_hole + '" type="text" class="knob" value="1" data-min="1" data-max="1000" data-width="180" data-height="180" data-fgcolor="' + tee_box_colors[i]+ '" ' +
                'style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;"> ' +
                '</div><div class="knob-label" style="color: white;">' + tee_box_colors[i] + '\'s Distance</div></div>';


        // handicap 2 ?
        for (i = 1; i < Handicap_number; i++)
            box_color_input.innerHTML +=
                '<div class="col-xs-12 col-sm-6 col-md-3 text-center centered"><div style="display:inline;width:180px;height:180px;">' +
                '<input name="hc_' + (i + 1) + '_' + current_hole + '" type="text" class="knob" value="1" data-min="1" data-max="18" data-width="180" data-height="180" data-fgcolor="orange" ' +
                'style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background-image: none; font-style: normal; font-variant-caps: normal; font-weight: bold; font-size: 18px; line-height: normal; font-family: Arial; text-align: center; color: rgb(0, 166, 90); padding: 0px; -webkit-appearance: none; background-position: initial initial; background-repeat: initial initial;"> ' +
                '</div><div class="knob-label" style="color: white;">Women\'s Handicap</div></div>';


        node.innerHTML = '<div id="hole-' + current_hole + '-distances" class="box box-success" style="background-color: #2c3b41; border-top-color: #2c3b41; display: none">'
            + '<div class="box-header with-border" style="width: 100%; text-align: center"><h3 class="box-title" style="text-align: center; font-size: 200%; color: ghostwhite">HOLE #' + current_hole + '</h3></div>'
            + '<div class="box-body" style="background-color: #2c3b41; border-top-color: #2c3b41;">'
            + box_color_input.innerHTML
            + '</div>'
            + '<div class="box-footer" style="background-color: #2c3b41; border-top-color: #2c3b41;">'
            + '<button type="button" class="btn btn-default" onclick="'
            + (current_hole == 1 ? 'HideMeShow(\'hole-1-distances\',\'Tee-Box-Color-Section\')' : 'HideMeShow(\'hole-' + current_hole + '-distances\',\'hole-' + (current_hole - 1) + '-distances\')')
            + '"><< Back</button>'
            + '<button ' + (current_hole === 18 ? 'type="submit"' : 'type="button"')
            + ' class="btn btn-info pull-right" onclick="'
            + (current_hole != 18 ? 'validateDistance(\'' + current_hole + '\')' : '')
            + '">'
            + (current_hole != 18 ? 'Next >>' : 'Submit') + '</button></div></div>';
        container.innerHTML += node.innerHTML;
    } while (current_hole++ < total_holes);

    $(".knob").knob({
        /*change : function (value) {
         //console.log("change : " + value);
         },
         release : function (value) {
         console.log("release : " + value);
         },
         cancel : function () {
         console.log("cancel : " + this.value);
         },*/
        draw: function () {

            // "tron" case
            if (this.$.data('skin') == 'tron') {

                var a = this.angle(this.cv)  // Angle
                    , sa = this.startAngle          // Previous start angle
                    , sat = this.startAngle         // Start angle
                    , ea                            // Previous end angle
                    , eat = sat + a                 // End angle
                    , r = true;

                this.g.lineWidth = this.lineWidth;

                this.o.cursor
                && (sat = eat - 0.3)
                && (eat = eat + 0.3);

                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.value);
                    this.o.cursor
                    && (sa = ea - 0.3)
                    && (ea = ea + 0.3);
                    this.g.beginPath();
                    this.g.strokeStyle = this.previousColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
    });

}
