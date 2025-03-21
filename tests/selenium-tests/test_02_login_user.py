from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import pytest


def test_02_login_user():
    # Setup driver and wait
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()
    driver = webdriver.Chrome(service=service, options=options)
    wait = WebDriverWait(driver, 10)

  
    driver.get("http://localhost:8000")
    login_button = wait.until(EC.presence_of_element_located((By.XPATH, "//a[contains(text(),'Login')]")))
    login_button.click()

    # Wait for login form and fill in credentials
    wait.until(EC.presence_of_element_located((By.NAME, "CustomerEmail"))).send_keys("john1@example.com")
    driver.find_element(By.NAME, "CustomerPassword").send_keys("SecurePass123")

    # Click the login button
    driver.find_element(By.XPATH, "//input[@value='Login']").click()  # Adjust if your login button has a different name or type

    # Assert login success – for example, redirected to dashboard or welcome message
    found_bar = wait.until(EC.presence_of_element_located((By.XPATH, "//div[@id='nav']")))
    assert found_bar is not None

    

    driver.quit()
