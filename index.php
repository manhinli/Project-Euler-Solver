<?php
    // Includes for the whole page
    include_once(__DIR__."/classes/Problems.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>Project Euler Solver</title>
    
    <link rel="stylesheet" href="static/css/normalize.css" />
    <link rel="stylesheet" href="static/css/stylesheet.css" />
    
    <script src="static/js/jquery-2.2.3.min.js"></script>
    <script src="static/js/script.js"></script>
</head>
<body>
    <div id="header">
        <h1>
            <a href="/">Project Euler Solver</a>
        </h1>
    </div>
    <div id="content">
        <div id="nav">
<?php
    // Generate the links to each problem
    foreach (Problems::fetchAll() as $problemInfo) {
        echo <<<EOT
            <a href="/?id=$problemInfo[id]" data-problem-id="$problemInfo[id]">$problemInfo[title]</a>
EOT;
    }
?>
        </div>
        <div id="card-workspace">
<?php
    // If there is an ID given, load that card in
    
    if (isset($_GET["id"])) {
        $reqProbId = intval($_GET["id"]);
    }
    
    if (isset($_POST["problem_id"])) {
        $reqProbId = intval($_POST["problem_id"]);
    }
    
    if (isset($reqProbId)) {
        $problemInfo = Problems::fetch($reqProbId);
        
        // Partially create HTML for the card
        $card_problemInfo = <<<EOT
            <div class="card problem" data-problem-id="$problemInfo[id]">
                <div class="problem-info">
                    <h2 class="problem-title">$problemInfo[title]</h2>
                    <div class="problem-statement">$problemInfo[statement]</div>
                    <a class="proj-euler-link" href="https://projecteuler.net/problem=$problemInfo[id]">View this problem on Project Euler »</a>
                </div>
                <form class="problem-input-form" method="post">
                    <input type="hidden" name="problem_id" value="$problemInfo[id]" />
                    <label>
                        <div class="problem-input-label">$problemInfo[input_label]</div>
                        <input type="text" name="input" autofocus />
                    </label>
                    <input type="submit" value="Solve!"/>
                </form>
EOT;
        
        // If we're supposed to generate the solution, then include it in the
        // problem info card
        if (isset($_POST["input"])) {
            $solverClass = "Solver" . $reqProbId;

            include_once(__DIR__."/solvers/" . $solverClass . ".php");

            $solver = new $solverClass();

            // Run the solver
            $input = trim($_POST["input"]);
            
            try {
                $solutionInfo = $solver->solve($input);
        
                $input_htmlEscaped = htmlspecialchars($solutionInfo[input]);
            
                $card_problemInfo .= <<<EOT
                <div class="solution success">
                    <div class="solution-input">$input_htmlEscaped</div>
                    <div class="solution-output">$solutionInfo[solution]</div>
                    <div class="clearfix"></div>
                    <div class="solution-compute-info">
                        <div class="cell solution-total-runs"><b>$solutionInfo[total_runs]</b> total runs of this solution</div>
                        <div class="cell solution-exec-time">$solutionInfo[exec_time] sec</div>
                    </div>
                </div>
EOT;
            } catch (Exception $e) {
                $input_htmlEscaped = htmlspecialchars($input);
                $exception_htmlEscaped = htmlspecialchars($e->getMessage());
                $card_problemInfo .= <<<EOT
                <div class="solution fail">
                    <p>$input_htmlEscaped</p>
                    <p>$exception_htmlEscaped</p>
                </div>
EOT;
            }
        }
        
        // Finish the card's HTML
        $card_problemInfo .= <<<EOT
            </div>
EOT;

    // Put the HTML in
    echo $card_problemInfo;

    }
?>
            <div class="card">
<?php if (!isset($reqProbId)) { ?>
                <h2>Welcome to the Project Euler Solver</h2>
                <p>Please select a problem to run our solver through.</p>        
<?php } ?>
                <p>Content and problem statements derived from <a href="https://projecteuler.net">Project Euler</a> licensed under <a href="https://creativecommons.org/licenses/by-nc-sa/2.0/uk/">Creative Commons BY-NC-SA 2.0 UK</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>