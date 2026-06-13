Set WshShell = CreateObject("WScript.Shell")
scriptPath = WshShell.CurrentDirectory & "\toggle-keyboard.ps1"
WshShell.Run "powershell.exe -ExecutionPolicy Bypass -WindowStyle Hidden -File """ & scriptPath & """", 0, False
