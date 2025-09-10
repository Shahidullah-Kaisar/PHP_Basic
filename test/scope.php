<!-- 1. Local Scope -->
<!-- Variable যদি function এর ভেতর declare করা হয়, সেটা function এর বাইরে পাওয়া যায় না। -->
<?php
function test() {
    $x = 10;   // local variable
    echo "Inside function: $x <br>";
}

test();
echo "Outside function: $x";  // ❌ Error, কারণ $x local
?>


<!-- 2. Global Scope -->
<!-- 👉 Function এর বাইরে declare করা variable শুধু বাইরে ব্যবহার করা যায়। -->

<?php
$y = 20;  // global variable

function demo() {
    // echo "Inside function: $y"; // ❌ Direct access possible না
}

demo();
echo "Outside function: $y <br>";  // ✅ এখানে কাজ করবে
?>


<!-- 3. Using global keyword -->
<!-- 👉 Function এর ভেতর থেকেও global variable ব্যবহার করতে চাইলে global লিখতে হয়। -->

<?php
$z = 30;

function show() {
    global $z;
    echo "Inside function: $z <br>";
}

show();
echo "Outside function: $z";
?>


<!-- 4. Static Scope -->
<!-- 👉 Function বারবার call করলে normally variable reset হয়ে যায়।
কিন্তু static দিলে value মনে রাখে। -->

<?php
function counter() {
    static $count = 0;
    
    $count++;
    echo "Count is: $count <br>";
}

counter();
counter();
counter();
?>
