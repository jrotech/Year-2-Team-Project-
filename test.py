text = "{\"Name\": {\"Product Type\": \"Internal SSD (Solid State Drive)\"}, \"Features\": {\"Buffer\": \"4,096\\u00a0MB\", \"Read Speed\": \"7,450\\u00a0MB/s\", \"Write Speed\": \"6,900\\u00a0MB/s\", \"MTBF\": \"1,500,000\\u00a0hours\", \"Maximum Write Volume (TBW)\": \"2,400\", \"4K Random Read IOPS\": \"1,600,000\", \"4K Random Write IOPS\": \"1,550,000\"}, \"Properties\": {\"Capacity\": \"4,000\\u00a0GB\", \"Design\": \"Internal\", \"Memory Type\": \"3D V-NAND\", \"Bus\": \"PCIe 4.0 x4\", \"RAM Type\": \"LPDDR4\", \"Protokoll\": \"NVMe\", \"Features\": \"TRIM Support, SMART, Garbage Collection, Device Sleep\", \"Power Consumption (Operating)\": \"8.5\\u00a0Watt\", \"Encryption\": \"AES 256-Bit\", \"Production Process\": \"8\\u00a0nm\"}, \"Environmental Conditions\": {\"Shock-resistant up to\": \"1,500\\u00a0G\", \"Operating Temperature\": \"0 - 70\\u00a0\\u00b0C\"}, \"Dimensions & Weight\": {\"Form Factor\": \"M.2\", \"Height\": \"2.3\\u00a0mm\", \"Weight\": \"9\\u00a0g\", \"Width\": \"22\\u00a0mm\", \"Length\": \"80\\u00a0mm\"}, \"Additional Information\": {\"Source\": \"*\\u00d8 Eurostat Electricity Price (as of 1st Half of 2020)\", \"\": null}}"
import json 

# Convert string to dictionary
data_dict = json.loads(text)

# Save dictionary as JSON file
with open("dump.json", "w", encoding="utf-8") as json_file:
    json.dump(data_dict, json_file, indent=4, ensure_ascii=True)
