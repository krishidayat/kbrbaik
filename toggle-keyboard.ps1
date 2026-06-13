$instanceId = 'ACPI\FUJ7401\4&1FA0D86&0'
$device = Get-PnpDevice -InstanceId $instanceId

if ($device.Status -eq 'OK') {
    Disable-PnpDevice -InstanceId $instanceId -Confirm:$false
    $msg = "Keyboard bawaan: OFF"
} else {
    Enable-PnpDevice -InstanceId $instanceId -Confirm:$false
    $msg = "Keyboard bawaan: ON"
}

Write-Host $msg
Start-Sleep -Seconds 1
