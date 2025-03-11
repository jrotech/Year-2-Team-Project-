import re

value = "2 x Hyper M.2, 4 x S-ATA3 600"

m2_matches = re.findall(r"(\d+)\s*[xX]\s*(?:Hyper\s+|Ultra\s+)?M\.?2", value, re.IGNORECASE)
print(f"Extracted M.2 Matches: {m2_matches}")
sum_of_m2 = sum(map(int, m2_matches))
print(f"Total M.2 Connectors: {sum_of_m2}")
