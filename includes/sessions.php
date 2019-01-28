<?php

session_start();

function ErrorMessage() {
    if(isset($_SESSION["ErrorMessage"])) {
        $Output = "<div class='alert alert-danger'>";
            $Output .= "<div class='container'>";
                $Output .= "<div class='alert-icon'>";
                    $Output .= "<i class='material-icons' style='color: white;'>error_outline</i>";
                $Output .= "</div>";

                $Output .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                    $Output .= "<span aria-hidden='true'><i class='material-icons'>clear</i></span>";
                $Output .= "</button>";

                $Output .= htmlentities($_SESSION["ErrorMessage"]);
            $Output .= "</div>";
        $Output .= "</div>";

        $_SESSION["ErrorMessage"] = null;
        return $Output;
    };
};

function SuccessMessage() {
    if(isset($_SESSION["SuccessMessage"])) {
        $Output = "<div class='alert alert-success'>";
            $Output .= "<div class='container'>";
                $Output .= "<div class='alert-icon'>";
                    $Output .= "<i class='material-icons' style='color: white;'>check</i>";
                $Output .= "</div>";

                $Output .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                    $Output .= "<span aria-hidden='true'><i class='material-icons'>clear</i></span>";
                $Output .= "</button>";

                $Output .= htmlentities($_SESSION["SuccessMessage"]);
            $Output .= "</div>";
        $Output .= "</div>";

        $_SESSION["SuccessMessage"] = null;
        return $Output;
    };
};

?>