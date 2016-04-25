(function($) {
    // On init
    var $XHR_problems = $.ajax({
        url: "/api/problems.php",
        method: "GET",
        dataType: "json"
    });



    // On DOM ready
    $(function() {
        var $nav = $("#nav");
        var $cardWorkspace = $("#card-workspace");
        
        $XHR_problems
            .done(function(data) {
                var $nav_itemTemplate = $("<a>");
                
                $nav.append(
                    data.map(function(problemInfo) {
                        // Copy template and insert info
                        // Using jQuery#attr() instead of jQuery#data() to take
                        //  advantage of CSS content()
                        return $nav_itemTemplate.clone()
                                .text(problemInfo.title)
                                .attr({
                                    "data-problem-id": problemInfo.id,
                                    "href": "/?id=" + problemInfo.id
                                });
                    })
                );
            });
            
            
            
        $nav.on("click", "a", function(e) {
            e.preventDefault();
            
            var problemId = $(this).attr("data-problem-id");
            
            // Load problem info
            $.ajax({
                url: "/api/problem.php",
                data: {
                    "id": problemId
                },
                method: "GET",
                dataType: "json"
            }).done(function(problemInfo) {
                var $card_problem = $("<div>")
                                        .addClass("card problem")
                                        .attr({
                                            "data-problem-id": problemInfo.id
                                        })
                                        .append([
                                            $("<div>")
                                                .addClass("problem-statement")
                                                .append([
                                                    $("<h2>").text(problemInfo.title),
                                                    $("<div>").html(problemInfo.statement),
                                                    $("<a>").text("See this problem on Project Euler").prop("href", "https://projecteuler.net/problem="+problemInfo.id)  
                                                ]),
                                            
                                            $("<form>")
                                                .addClass("problem-input-form")
                                                .attr({
                                                    "data-problem-id": problemInfo.id
                                                })
                                                .append([
                                                    $("<input>").prop({
                                                        "placeholder": problemInfo.input_label,
                                                        "name": "input"
                                                    })
                                                ])
                                        ])
                                        
                $cardWorkspace.prepend($card_problem);
            });
            
            
        });
        
        
        $cardWorkspace.on("submit", "form.problem-input-form", function(e) {
            e.preventDefault();
            
            var problemId = $(this).attr("data-problem-id");
            var inputVal = $("input", this).val();
            
            
            
            // Load solutions below form
            var $solution = $("<div>")
                                .addClass("solution")
                                .append([
                                    $("<p>").text(inputVal)
                                ])
            
            // Load
            $solution.addClass("in-progress");
            
            $.ajax({
                url: "/api/solve.php",
                method: "POST",
                data: {
                    "problemId": problemId,
                    "input": inputVal
                },
                dataType: "json"
            })
                .done(function(solutionInfo) {
                    $solution
                        .removeClass("in-progress")
                        .addClass("success")
                        .append([
                            $("<p>").text(solutionInfo.solution),
                            $("<p>").text("Total runs = " + solutionInfo.totalRuns),
                            $("<p>").text("This took " + solutionInfo.execTime + "s")
                        ]);
                })
                .fail(function() {
                    $solution
                        .removeClass("in-progress")
                        .addClass("fail")
                        .append([
                            $("<p>").text("Something went wrong :(")
                        ]);
                })
            
            // Insert the $solution DOM element after the form
            $(this).after($solution);
            
            // Reset the form
            this.reset();
        });
    });
    
})($);