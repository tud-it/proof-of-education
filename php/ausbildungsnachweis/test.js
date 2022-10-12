function is_equal(a,b) {
    if(typeof(a) == typeof(b) && a==b) {
        return true;
    }
    return false;
}
function test_equal (test_name, a, b) {
    if(is_equal(a,b)) {
        number_tests_sucessful++;
        return true;
    }
    console.log("Test " + test_name + " failed. Is: " + a + " (" + typeof(a) + "), should be " + b + " (" + typeof(b) + ")");
    number_tests_failed++;
    return false;
}
function test_not_equal (test_name, a, b) {
    if(!is_equal(a,b)) {
        number_tests_sucessful++;
        return true;
    }
    console.log("Test " + test_name + " failed. Is: " + a + " (" + typeof(a) + "), should be different from " + b + " (" + typeof(b) + ")");
    number_tests_failed++;
    return false;
}

// Tests zu ausbildungsnachweis.php
is_equal(15, 16);
test_equal("search_tag_id", search_tag_id("2021-09-03"), "1197");


// Auswertung
var total_number_of_tests = number_tests_sucessful + number_tests_failed;
if(total_number_of_tests == 0) {
    console.log("No tests were run");
}
if(number_tests_failed == 0) {
    console.log("Ran " + total_number_of_tests + " All sucessfull.")

} else {
    console.log("Ran " + total_number_of_tests + ". " + number_tests_failed + " failed.");
}
process.exit(number_tests_failed)
