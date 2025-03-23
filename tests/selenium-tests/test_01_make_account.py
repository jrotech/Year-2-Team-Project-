from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import pytest

def test_01_make_account():
    # Setup webdriver and explicit wait
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()
    driver = webdriver.Chrome(service=service, options=options)
    wait = WebDriverWait(driver, 10)

    # Navigate to the homepage
    driver.get("http://localhost:8000")

    # Click the "Login" link
    login_button = wait.until(EC.presence_of_element_located(
        (By.XPATH, "//a[contains(text(),'Login')]")
    ))
    login_button.click()

    # Click the "Make an account" button to navigate to the registration page
    make_account_button = wait.until(EC.presence_of_element_located((By.XPATH, "//button[contains(text(),'Make an account')]")))
    make_account_button.click()

    # Fill in the registration form
    wait.until(EC.presence_of_element_located((By.NAME, "CustomerName"))).send_keys("John Boe")
    driver.find_element(By.NAME, "CustomerEmail").send_keys("john1@example.com")
    driver.find_element(By.NAME, "CustomerPassword").send_keys("SecurePass123")
    driver.find_element(By.NAME, "CustomerPassword_confirmation").send_keys("SecurePass123")
    driver.find_element(By.NAME, "CustomerPhone").send_keys("1234567890")
    
    # Submit the registration form
    driver.find_element(By.NAME, "Register").click()

    # Assert that the success message is displayed, indicating registration was successful
    success_message = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "div.alert")))
    assert "Registration successful" in success_message.text, (f"Expected registration success message not found. Found: '{success_message.text}'")

    driver.quit()
