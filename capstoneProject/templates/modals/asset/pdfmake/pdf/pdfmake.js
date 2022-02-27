function download(){
var docDefinition = {
    content: [
        /** Cases */
        {
            columns:[
                {
                    text: 'Charts',
                    style: 'header',
                }
            ]
        },
        { 
            image: document.getElementById("charts").innerHTML,
            fit: [500,500]
        },
        /** Brgy */
        {
            columns:[
                {
                    text: 'Distric 4 San Pablo City',
                    style: 'header',
                }
            ]
        },
        { 
            image: document.getElementById("districtPie").innerHTML,
            fit: [500,500],
            pageBreak: 'after'
        },
        /** Yearly Cases */
        {
            columns:[
                {
                    text: 'Yearly Cases in '+ user_location,
                    style: 'header',
                }

            ]
        },
        { 
            image: document.getElementById("yearPie").innerHTML,
            fit: [500,500]
        },

        /** Monthly Cases */
        {
            columns:[
                {
                    text: 'Monthly Cases in '  + user_location,
                    style: 'header',
                }

            ]
        },
        { 
            image: document.getElementById("monthlyBrackets").innerHTML,
            fit: [500,500],
            pageBreak: 'after'
        },
        /** Yearly Deceased */
        {
            columns:[
                {
                    text: 'Yearly Deceased in '+ user_location,
                    style: 'header',
                }

            ]
        },
        { 
            image: document.getElementById("deceasedYear").innerHTML,
            fit: [500,500]
        },

        /** Monthly Deceased */
        {
            columns:[
                {
                    text: 'Monthly Deceased in '+ user_location,
                    style: 'header',
                }

            ]
        },
        { 
            image: document.getElementById("deceasedMonth").innerHTML,
            fit: [500,500],
            pageBreak: 'after'
        },
        /** Monthly Cases Table for Female*/
        {
            columns:[
                {
                    text: 'Common Cases For Female',
                    style: 'header',
                }
            ]
        },
        {
            style:"tableStyle",
            columns:[
                {
                    table:{
                        widths:['30%',"30%","30%"],
                        body:[
                            ["Cases","Count","Deceased"],
                            [female_table_cases[0],female_table_cases[1],female_table_cases[2]]
                        ]
                    }
                }
            ],
            pageBreak: 'after'
        },
        /** Monthly Cases Table For Male*/
        {
            columns:[
                {
                    text: 'Common Cases For Male',
                    style: 'header',
                }
            ]
        },
        {
            style:"tableStyle",
            columns:[
                {
                    table:{
                        widths:['30%',"30%","30%"],
                        body:[
                            ["Cases","Count","Deceased"],
                            [male_table_cases[0],male_table_cases[1],male_table_cases[2]]
                        ]
                    }
                }
            ],
            pageBreak: 'after'
        },
        /** Monthly Cases Table For Newborn*/
        {
            columns:[
                {
                    text: 'Common Cases For Newborn',
                    style: 'header',
                }
            ]
        },
        {
            style:"tableStyle",
            columns:[
                {
                    table:{
                        widths:['30%',"30%","30%"],
                        body:[
                            ["Cases","Count","Deceased"],
                            [newborn_table_cases[0],newborn_table_cases[1],newborn_table_cases[2]]
                        ]
                    }
                }
            ],
            pageBreak: 'after'
        },
        /** Monthly Cases Table For Infant*/
        {
            columns:[
                {
                    text: 'Common Cases For Infant',
                    style: 'header',
                }
            ]
        },
        {
            style:"tableStyle",
            columns:[
                {
                    table:{
                        widths:['30%',"30%","30%"],
                        body:[
                            ["Cases","Count","Deceased"],
                            [infant_table_cases[0],infant_table_cases[1],infant_table_cases[2]]
                        ]
                    }
                }
            ],
            pageBreak: 'after'
        },
        /** Monthly Cases Table For kid*/
        {
            columns:[
                {
                    text: 'Common Cases For Kid',
                    style: 'header',
                }
            ]
        },
        {
            style:"tableStyle",
            columns:[
                {
                    table:{
                        widths:['30%',"30%","30%"],
                        body:[
                            ["Cases","Count","Deceased"],
                            [kid_table_cases[0],kid_table_cases[1],kid_table_cases[2]]
                        ]
                    }
                }
            ],
            pageBreak: 'after'
        },
        /** Monthly Cases Table For adult*/
        {
            columns:[
                {
                    text: 'Common Cases For Adult',
                    style: 'header',
                }
            ]
        },
        {
            style:"tableStyle",
            columns:[
                {
                    table:{
                        widths:['30%',"30%","30%"],
                        body:[
                            ["Cases","Count","Deceased"],
                            [adult_table_cases[0],adult_table_cases[1],adult_table_cases[2]]
                        ]
                    }
                }
            ],
            pageBreak: 'after'
        },
    ],
    styles: {
        header: {
            fontSize: 18,
            bold: true,
            alignment: 'center',
            width:'auto'
			//margin: [0, 190, 0, 80]
        },
        tableStyle:{
            bold:true,
            fontSize:14
        }
    }
};
pdfMake.createPdf(docDefinition).download('Print.pdf');
}
$(document).ready(function(){
    function gets_key(val){
        var i = 0;
        var get_val = [];
        var get_key = [];
        var get_list = [""];
        for (const [key, value] of Object.entries(val)) {
            get_val[i] = `${value}`;
            get_key[i] = `${key}`;
            i++;
        }
        var get_list = [[get_key],[get_val]];
        return get_list;
    }
    
    //console.log(female_table_cases[0]);
    
    function values(val){
        var i = 0;
        var month_value = [];
        for (const [key, value] of Object.entries(val)) {
            month_value[i] = `${value}`;
            i++;
            
          }
        return month_value;
    }
    //gender list
    const gender = ['Female','Male','Newborn','Infant','Todler','Kid','Adult'];
    
    //year data
    const gender_year = [
        arr['yearFemale'],
        arr['yearMale'],
        arr['yearNewborn'],
        arr['yearInfant'],
        arr['yearTodler'],
        arr['yearKid'],
        arr['yearAdult']
    ];
    const deceased_year = [
        arr_deceased['yearFemale'],
        arr_deceased['yearMale'],
        arr_deceased['yearNewborn'],
        arr_deceased['yearInfant'],
        arr_deceased['yearTodler'],
        arr_deceased['yearKid'],
        arr_deceased['yearAdult']
    ];
    
    const year_data = {
        labels:gender,
        datasets: [{
            labels:'Yearly Record',
            data:gender_year,
            fillColor: "rgba(220,220,220,0.5)", 
            strokeColor: "rgba(220,220,220,0.8)", 
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","#FF3395","#FFCD80","#FFC600"],
        }]
    }
    const year_deceased = {
        labels:gender,
        datasets: [{
            labels:'Yearly Record',
            data:deceased_year,
            fillColor: "rgba(220,220,220,0.5)", 
            strokeColor: "rgba(220,220,220,0.8)", 
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            backgroundColor: ["#FF6384", "#FFCD56", "#FF9F40", "#36A2EB","#FF3395","#FFCD80","#FFC600"],
        }]
    }
    var month_labels_PDF = [];
    var i=0
    for (const [key, value] of Object.entries(female_value)) {
        month_labels_PDF[i] = `${key}`;
        i++;
      }
        /** values */
        var female_month_value = values(female_value);
        var male_month_value = values(male_value);
        var newborn_month_value = values(newborn_value);
        var infant_month_value = values(infant_value);
        var todler_month_value = values(todler_value);
        var kid_month_value = values(kid_value);
        var adult_month_value = values(adult_value);
    
        var deceased_female = values(female_value_deceased);
        var deceased_male = values(male_value_deceased);
        var deceased_newborn = values(newborn_value_deceased);
        var deceased_infant = values(infant_value_deceased);
        var deceased_todler = values(todler_value_deceased);
        var deceased_kid = values(kid_value_deceased);
        var deceased_adult = values(adult_value_deceased);
    
        /** Cases */
        const month_data = {
        labels:month_labels_PDF, 
        datasets: [
        {
            label:"Female",
            data:female_month_value,
            backgroundColor: 'red'
        },
        {
            label:'Male',
            data:male_month_value,
            backgroundColor:'green'
        },
        {
            label:'Newborn',
            data:newborn_month_value,
            backgroundColor:'blue'
        },
        {
            label:'Infant',
            data:infant_month_value,
            backgroundColor:'yellow'
        },
        {
            label:'Todler',
            data:todler_month_value,
            backgroundColor:'#FF6384'
        },
        {
            label:'Kid',
            data:kid_month_value,
            backgroundColor:'#FF9F40'
        },
        {
            label:'Adult',
            data:adult_month_value,
            backgroundColor:"#36A2EB"
        },]}
        /** Deceased */
        const deceased_month_data = {
            labels:month_labels_PDF, 
            datasets: [
            {
                label:"Female",
                data:deceased_female,
                backgroundColor: 'red'
            },
            {
                label:'Male',
                data:deceased_male,
                backgroundColor:'green'
            },
            {
                label:'Newborn',
                data:deceased_newborn,
                backgroundColor:'blue'
            },
            {
                label:'Infant',
                data:deceased_infant,
                backgroundColor:'yellow'
            },
            {
                label:'Todler',
                data:deceased_todler,
                backgroundColor:'#FF6384'
            },
            {
                label:'Kid',
                data:deceased_kid,
                backgroundColor:'#FF9F40'
            },
            {
                label:'Adult',
                data:deceased_adult,
                backgroundColor:"#36A2EB"
            },
        
        ]
        }
    
    //year gender record
    var ctx_gender_year = document.getElementById("year");
    var bar_gender_year = new Chart(ctx_gender_year, {
        type:'pie',
        data:year_data,
        options:{
            animation:{
                onComplete : function(){
                  document.getElementById("yearPie").innerHTML = bar_gender_year.toBase64Image();
                }
            }
        }
    });
    //month gender record
    var ctx_gender_month = document.getElementById("month");
    var bar_month_year = new Chart(ctx_gender_month,{
        type:'bar',
        data:month_data,
        options: {
            plugins: {
              title: {
                display: true,
                text: 'Chart.js Bar Chart - Stacked'
              },
            },
            responsive: true,
            scales: {
                xAxes: [{
                   stacked: true // this should be set to make the bars stacked
                }],
                yAxes: [{
                   stacked: true // this also..
                }]
             },
             animation:{
                onComplete : function(){
                  document.getElementById("monthlyBrackets").innerHTML = bar_month_year.toBase64Image();
                }
            }
          }
    
    });
    /** Yearly Deceased */
    var ctx_deceased_year = document.getElementById("deceased_year");
    var bar_deceased_year = new Chart(ctx_deceased_year, {
        type:'pie',
        data:year_deceased,
        options:{
            animation:{
                onComplete : function(){
                  document.getElementById("deceasedYear").innerHTML = bar_deceased_year.toBase64Image();
                }
            }
        }
    });
    /** Monthly Deceased */
    var ctx_deceased_month = document.getElementById("deceased_month");
    var bar_deceased_month = new Chart(ctx_deceased_month,{
        type:'bar',
        data:deceased_month_data,
        options: {
            plugins: {
              title: {
                display: true,
                text: 'Chart.js Bar Chart - Stacked'
              },
            },
            responsive: true,
            scales: {
                xAxes: [{
                   stacked: true // this should be set to make the bars stacked
                }],
                yAxes: [{
                   stacked: true // this also..
                }]
             },
             animation:{
                onComplete : function(){
                  document.getElementById("deceasedMonth").innerHTML = bar_deceased_month.toBase64Image();
                }
            }
          }
    
    });
});
