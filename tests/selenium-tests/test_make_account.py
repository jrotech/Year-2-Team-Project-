from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import time

def test_make_account():
    # Use webdriver-manager to handle driver setup
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()
    driver = webdriver.Chrome(service=service, options=options)
    wait = WebDriverWait(driver, 10)

    driver.get("http://localhost:8000")
    time.sleep(2)

    # Wait until "Login" link is present and click it
    login_button = wait.until(EC.presence_of_element_located((By.XPATH, "//a[contains(text(),'Login')]")))
    login_button.click()

    # Wait until "Make an account" link is present and click it
    make_account_button = wait.until(EC.presence_of_element_located((By.XPATH, "//button[contains(text(),'Make an account')]")))
    make_account_button.click()

    wait.until(EC.presence_of_element_located((By.NAME, "CustomerName"))).send_keys("John Boe")
    driver.find_element(By.NAME, "CustomerEmail").send_keys("john1@example.com")
    driver.find_element(By.NAME, "CustomerPassword").send_keys("SecurePass123")
    driver.find_element(By.NAME, "CustomerPassword_confirmation").send_keys("SecurePass123")
    driver.find_element(By.NAME, "CustomerPhone").send_keys("1234567890")
    time.sleep(0.5)
    driver.find_element(By.NAME, "Register").click()
    
   
    driver.quit()

