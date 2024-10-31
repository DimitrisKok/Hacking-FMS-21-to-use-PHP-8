# Define paths
$javaHome = "C:\Program Files\FileMaker\FileMaker Server\Web Publishing\java"
$opensslConf = "C:\Program Files\FileMaker\FileMaker Server\Database Server\ssl\openssl.cnf"
$phpPath = "C:\Program Files\FileMaker\FileMaker Server\Web Publishing\publishing-engine\php"
$databaseServerPath = "C:\Program Files\FileMaker\FileMaker Server\Database Server\"

# Set JAVA_HOME if not set
if (-not (Test-Path -Path Env:JAVA_HOME)) {
    [System.Environment]::SetEnvironmentVariable("JAVA_HOME", $javaHome, [System.EnvironmentVariableTarget]::Machine)
}

# Set OPENSSL_CONF if not set
if (-not (Test-Path -Path Env:OPENSSL_CONF)) {
    [System.Environment]::SetEnvironmentVariable("OPENSSL_CONF", $opensslConf, [System.EnvironmentVariableTarget]::Machine)
}

# Update PATH if paths are not already added
$currentPath = [System.Environment]::GetEnvironmentVariable("Path", [System.EnvironmentVariableTarget]::Machine)
if ($currentPath -notlike "*$phpPath*") {
    [System.Environment]::SetEnvironmentVariable("Path", "$currentPath;$phpPath;$databaseServerPath;$javaHome\bin", [System.EnvironmentVariableTarget]::Machine)
}
