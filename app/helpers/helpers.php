<?php

    function gravatar($email) {
        return "https://gravatar.com/avatar/" . md5($email);
    }