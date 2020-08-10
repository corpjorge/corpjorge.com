<?php
// basic sequence with LDAP is connect, bind, search, interpret search
// result, close connection

echo "<h3>LDAP query test</h3>";
echo "Connecting ...";
$ds=ldap_connect("ldappr.uniandes.edu.co");  // must be a valid LDAP server!
echo "connect result is ".$ds."<p>";

if ($ds) {
    echo "Binding ...";
    //$r=ldap_bind($ds,"cn=Directory Manager","lolita");     // this is an "anonymous" bind, typically
    $r=ldap_bind($ds);     // this is an "anonymous" bind, typically
                           // read-only access
    echo "Bind result is ".$r."<p>";

    echo "Searching for (sn=S*) ...";
    // Search surname entry
    $sr=ldap_search($ds,"ou=people,dc=uniandes,dc=edu,dc=co", "uid=am.munoz1578");
    echo "Search result is ".$sr."<p>";

    echo "Number of entires returned is ".ldap_count_entries($ds,$sr)."<p>";

    echo "Getting entries ...<p>";
    $info = ldap_get_entries($ds, $sr);
    echo "Data for ".$info["count"]." items returned:<p>";

    for ($i=0; $i<$info["count"]; $i++  ) {
        echo "dn is: ". $info[$i]["dn"] ."<br>";
        echo "first cn entry is: ". $info[$i]["cn"][0] ."<br>";
        echo "first email entry is: ". $info[$i]["mail"][0] ."<p>";
        echo "first name entry is: ". $info[$i]["givenName"][0] ."<p>";
        echo "first bussines entry is: ". $info[$i]["businessCategory"][0] ."<p>";
        echo "first dNumbere entry is: ". $info[$i]["uidNumber"][0] ."<p>";
        echo "first mailuserstatus entry is: ". $info[$i]["mailuserstatus"][0] ."<p>";
        echo "first uid entry is: ". $info[$i]["uid"][0] ."<p>";
    }

    echo "Closing connection";
    ldap_close($ds);

} else { 
    echo "<h4>Unable to connect to LDAP server</h4>"; 
} 
?>
