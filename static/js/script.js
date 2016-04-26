(function($) {
    // Templates and core functions
    function createProblemCard(problemInfo) {
        var $card_problem = $('\
            <div class="card problem">\
                <div class="problem-info">\
                    <h2 class="problem-title"></h2>\
                    <div class="problem-statement"></div>\
                    <a class="proj-euler-link">View this problem on Project Euler »</a>\
                </div>\
                <form class="problem-input-form" method="post">\
                    <input type="hidden" name="problem_id" />\
                    <label>\
                        <div class="problem-input-label"></div>\
                        <input type="text" name="input" autofocus />\
                    </label>\
                    <input type="submit" value="Solve!" />\
                </form>\
            </div>');
          
        // Fill in content
        $card_problem.attr("data-problem-id", problemInfo.id);
        $(".problem-title", $card_problem).html(problemInfo.title);
        $(".problem-statement", $card_problem).html(problemInfo.statement);
        $(".proj-euler-link", $card_problem).prop("href", "https://projecteuler.net/problem=" + problemInfo.id)
        $("form.problem-input-form input[name='problem_id']", $card_problem).val(problemInfo.id);
        $(".problem-input-label", $card_problem).html(problemInfo.input_label);
        
        return $card_problem;
    }
    
    function createSolutionBlock() {
        var $solution = $('\
            <div class="solution">\
                <div class="solution-input"></div>\
                <div class="solution-output"></div>\
                <div class="clearfix"></div>\
                <div class="solution-compute-info">\
                    <div class="cell solution-total-runs"><b class="solution-total-run-value"></b> total run<span class="solution-total-run-value-plural">s</span> of this solution</div>\
                    <div class="cell solution-exec-time"><span class="solution-exec-time-value"></span> sec</div>\
                </div>\
                <div class="solution-exception"></div>\
                <a href="#" class="solution-close">Close this solution</a>\
                <div class="clearfix"></div>\
            </div>');
            
        // Manage content
        $(".solution-compute-info", $solution).hide();
            
        return $solution;
    }
    
    function loadProblemCard(problemId, $cardWorkspace, disableHistoryPush) {
        var $topProblemCard = $(".card.problem", $cardWorkspace).eq(0);
        
        if ($topProblemCard.attr("data-problem-id") === problemId) {
            // Don't load again, focus into form
            $("form.problem-input-form *:input[type!=hidden]:first", $topProblemCard).focus();
            return;
        }
        
        // Create placeholder card
        var $card_placeholder = $("<div>")
                                    .addClass("card loading")
                                    .html("Loading Problem <b>#" + problemId + "</b>...");
                                    
        $cardWorkspace.prepend($card_placeholder);
        
        // Modify the URL and history to reflect new problem load
        if (!disableHistoryPush){
            history.pushState({ problemId: problemId }, document.title, "?id=" + problemId);
        }
        
        // Scroll to the top so the user knows that problem info is loading
        $cardWorkspace.scrollTop(0);
        
        // Load problem info
        $.ajax({
            url: "/api/problem.php",
            data: {
                "id": problemId
            },
            method: "GET",
            dataType: "json"
        }).done(function(problemInfo) {
            var $card_problem = createProblemCard(problemInfo);
            
            $card_placeholder.after($card_problem);
            $card_placeholder.remove();
            
            $("form.problem-input-form *:input[type!=hidden]:first", $card_problem).focus();
        });
    }
    
    
    // On DOM ready
    $(function() {
        var $nav = $("#nav");
        var $cardWorkspace = $("#card-workspace");
        
        // Selecting a new problem
        $nav.on("click", "a", function(e) {
            e.preventDefault();
            
            var problemId = $(this).attr("data-problem-id");
            
            loadProblemCard(problemId, $cardWorkspace);
        });
        
        // Submitting input to the solver
        $cardWorkspace.on("submit", "form.problem-input-form", function(e) {
            e.preventDefault();
            
            var problemId = $(this).closest(".card.problem").attr("data-problem-id");
            var inputVal = $.trim($("input[name='input']", this).val());
            
            // Load solutions below form
            var $solution = createSolutionBlock();
            $(".solution-input", $solution).text(inputVal);
            
            // Load
            $solution.addClass("in-progress");
            
            $.ajax({
                url: "/api/solve.php",
                method: "POST",
                data: {
                    "problem_id": problemId,
                    "input": inputVal
                },
                dataType: "json"
            })
                .done(function(solutionInfo) {
                    $solution
                        .removeClass("in-progress")
                        .addClass("success");
                    
                    $(".solution-output", $solution).text(solutionInfo.solution);
                    $(".solution-total-run-value", $solution).text(solutionInfo.total_runs);
                    $(".solution-exec-time-value", $solution).text(solutionInfo.exec_time);
                    
                    if (solutionInfo.total_runs === 1) {
                        $(".solution-total-run-value-plural", $solution).remove();
                    }
                    
                    $(".solution-compute-info", $solution).show();
                })
                .fail(function(jqXHR) {
                    $solution
                        .removeClass("in-progress")
                        .addClass("fail");
                    
                    var exceptionMessage = "An unknown error has occurred. Please check your input and try again later.";
                    
                    if (jqXHR.responseText) {
                        var responseJson = $.parseJSON(jqXHR.responseText);
                        
                        if (responseJson.error) {
                            exceptionMessage = responseJson.error;    
                        }
                    }
                    
                    $(".solution-exception", $solution).text(exceptionMessage);
                })
            
            // Insert the $solution DOM element after the form
            $(this).after($solution);
            
            // Reset the form
            this.reset();
        });
        
        // Closing a solution
        $cardWorkspace.on("click", "a.solution-close", function(e) {
            e.preventDefault();
            
            $(this).closest(".solution").remove();
        });
        
        // On history going back/forwards
        $(window).on("popstate", function(e) {
            var state = e.originalEvent.state;
            
            // Also load the problem card if we go backward/forwards in history
            if (state.problemId) {
                loadProblemCard(state.problemId, $cardWorkspace, true);
            }
        });
        
    });
    
})($);