@ECHO OFF
IF NOT "%~f0" == "~f0" GOTO :WinNT
@"%SproutCorePath%/ruby/bin/ruby.exe" -I "%SproutCorePath%/local/sproutcore/bundle" -r bundler/setup "sc-init" %1 %2 %3 %4 %5 %6 %7 %8 %9
GOTO :EOF
:WinNT
@"%SproutCorePath%/ruby/bin/ruby.exe" -I "%SproutCorePath%/local/sproutcore/bundle" -r bundler/setup "%~dpn0" %*
