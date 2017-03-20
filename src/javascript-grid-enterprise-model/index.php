<?php
$key = "Quick Filter";
$pageTitle = "JavaScript Grid Enterprise Model";
$pageDescription = "the most advanced row model for ag-Grid is the Enterprise row model, allowing server side grouping and aggregation.";
$pageKeyboards = "ag-Grid Enterprise Row Model";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<h2 id="enterpriseRowModel">
    <img src="../images/enterprise_50.png" title="Enterprise Feature"/>
    Enterprise Row Model
</h2>

<div class="note">
    <table>
        <tbody><tr>
            <td style="vertical-align: top;">
                <img src="../images/lab.png" title="Enterprise Lab" style="padding: 10px;">
            </td>
            <td style="padding-left: 10px;">
                <h4 class="ng-scope">
                    Lab Feature - Not For Production
                </h4>
                <p class="ng-scope">
                    Enterprise Row Model is currently in development, subject to change
                    and not all edge cases are coded for. The purpose of including this
                    feature in the latest release is to present the idea to our customers
                    and get feedback. Feel free to look, try it out, and give feedback.
                    However please do not plan a production release without first talking
                    to us so we know what dependencies we have.
                </p>
            </td>
        </tr>
        </tbody></table>
</div>

<h3>Introduction</h3>

<p>
    The default row model for ag-Grid, the In Memory row model, will do grouping and
    aggregation for you if you give it all the data. If the data will not fit in the browser
    because it is to large, then you can use one of a) server side pagination b) infinite
    scrolling or c) viewport. However all of these alternatives fall down as you loose
    the ability to do grouping and aggregation.
</p>

<p>
    The Enterprise Row Model presents the ability to have grouping and aggregation
    on large datasets by delegating the aggregation to the server and lazy loading
    the groups.
</p>

<p>
    Some users might simply see it as lazy loading group data from the server. Eg
    if you have a managers database table, you can display a list of all managers,
    then then click 'expand' on the manager and the grid will then request
    to get the 'employees' for that manager.
</p>

<p>
    Or a more advanced use case would be to allow the user to slice and dice a large
    dataset and have the backend generate SQL (or equivalent if not using a SQL
    store) to create the result. This would be similar to how current data analysis
    tools work, a mini-Business Intelligence experience.
</p>

<h3>How it Works</h3>

<p>
    You provide the grid with a datasource. The interface for the datasource is as follows:
</p>

<pre><span class=""></span>
interface IEnterpriseDatasource {
    getRows(params: IEnterpriseGetRowsParams): void;
}
</pre>

<h3>Example - Predefined Master Detail</h3>

<p>
    Below shows an example of predefined master / detail using the olympic winners.
    It is pre-defined as we set the grid with a particular grouping, and then
    our datasource knows that the grid will either be asking for the top level
    nodes OR the grid will be looking for the lower level nodes for a country.
</p>

<p>
</p>

<show-example example="exampleEnterpriseSimpleJsDb"></show-example>

<h3>Example - Slice and Dice</h3>

<p>
    Below shows an example of slicing and dicing the olympic winners. The example
    mimics asking the server for data by implementing a proxy
</p>

<show-example example="exampleEnterpriseSliceAndDiceJsDb"></show-example>

<h4>What's Left</h4>
<p>
    Before we believe the enterprise row model is ready for production, we want to solve
    the following problems:
    <ol>
        <li><b>Infinite Scrolling:</b> The grid works great at handling large data, as long as
        each groups children isn't small set. For example, if grouping by country, shop and
        widget, you could have 50 countries, 50 shops in each country, and 100 widgets in each
        shop. That means you will at most take 100 items back from the server in one call
        even thought there are 250,000 (50x50x100) widgets in total. However if the user
        decided to remove all grouping, and bring back all low levels rows, then that is a
        problem. It is our plan to implement infinite scrolling (similar to the
        <a href="../javascript-grid-virtual-paging/">infinite scrolling row model</a>)
        for each level of the grouping tree, so each group node will effectively have it's
        own infinite scroll, so the grid will in theory be able to handle an infinite
        amount of data, no matter how many children a particular group has.
        </li>
        <li><b>Caching Expiring of Data:</b> As a follow on from implementing infinite
        scrolling, data will also need to be cached and purged. Purging is important
        so the user is able to continually open and close groups with the browser
        indefinitely filling it's memory.</li>
        <li><b>Server Side Support:</b> Above we presented a demo of using MySQL as a client
        side database for generating SQL on the fly to do dynamic slicing and dicing of
        data from a Relational SQL database. We could extend our server side implementations
        to cover many of the popular SQL and no-SQL databases, in both JavaScript (for those
        doing NodeJS servers) and Java (for those working in finance, where Java is dominant
        for server side development).</li>
        <li></li>
    </ol>
</p>

<p>
    SQL for creating table in MySQL:
    <pre>create table olympic_winners (
    athlete varchar(20),
    age int,
    country varchar(20),
    country_group varchar(2),
    year int,
    date varchar(20),
    sport varchar(20),
    gold int,
    silver int,
    bronze int,
    total int
);</pre>

    Data was then exported from ag-Grid using <a href="../javascript-grid-export/">CSV Export</a> example
    and imported into MySQL database using <a href="https://www.mysql.com/products/workbench/">MySQL Workbench</a>.
    Enable PHP MySQL extension (uncomment mysql lines in php.ini).
</p>

<?php include '../documentation-main/documentation_footer.php';?>
