from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import pytest

def test_07_view_order():
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()
    driver = webdriver.Chrome(service=service, options=options)
    wait = WebDriverWait(driver, 10)

    # Navigate to site and login
    driver.get("http://localhost:8000")
    login_button = wait.until(EC.presence_of_element_located((By.XPATH, "//a[contains(text(),'Login')]")))
    login_button.click()

    # Fill in login form
    wait.until(EC.presence_of_element_located((By.NAME, "CustomerEmail"))).send_keys("john1@example.com")
    driver.find_element(By.NAME, "CustomerPassword").send_keys("SecurePass123")
    driver.find_element(By.XPATH, "//input[@value='Login']").click() 

    # Assert login success by checking navigation bar presence
    found_bar = wait.until(EC.presence_of_element_located((By.XPATH, "//div[@id='nav']")))
    assert found_bar is not None, "Login failed"

    # Go to Dashboard and click on Recent Orders
    driver.find_element(By.XPATH, "//a[contains(text(),'Dashboard')]").click()
    recent_orders_tag = wait.until(EC.presence_of_element_located((By.XPATH, "//h1[contains(text(),'Recent Orders')]")))
    assert recent_orders_tag is not None, "Recent Orders not found"

    # Click the first order details link
    first_order_details = driver.find_element(By.XPATH, "//a[contains(@href,'/dashboard/orders/')]")
    first_order_details.click()
    
    # Order Number
    order_number = driver.find_element(By.XPATH, "//h5[contains(text(),'Order Number:')]").text
    number = order_number.split(":")[1].strip()
    assert driver.current_url.endswith(f"/orders/{number}"), f"URL does not end with '/orders/{number}': {driver.current_url}"

    
    # Order Status
    order_status = driver.find_element(By.XPATH, "//*[contains(text(),'Order Status:')]").text
    assert "Pending" in order_status, f"Expected order status 'Pending', got '{order_status}'"
    
    # Order Total
    order_total = driver.find_element(By.XPATH, "//*[contains(text(),'Order Total:')]").text
    assert "£2607.92" in order_total, f"Expected order total '£2607.92', got '{order_total}'"
    
    # Shipping Address
    shipping_heading = driver.find_element(By.XPATH, "//h3[contains(text(),'Shipping Address:')]").text
    assert "Shipping Address:" in shipping_heading, "Shipping Address heading not found"
    address_text = driver.find_element(By.XPATH, "//p[contains(text(),'Address:')]").text
    assert "123 Main Street" in address_text, f"Expected address '123 Main Street', got '{address_text}'"
    postcode_text = driver.find_element(By.XPATH, "//p[contains(text(),'Postcode:')]").text
    assert "12345" in postcode_text, f"Expected postcode '12345', got '{postcode_text}'"
    
    
    # First Product: AMD Ryzen 7 9800X3D
    product1_title = driver.find_element(By.XPATH, "//h4[contains(text(),'AMD Ryzen 7 9800X3D')]").text
    assert "AMD Ryzen 7 9800X3D" in product1_title, "First product title not found"
    # Verify details by checking if expected texts are present in the page source
    assert "£478.99" in driver.page_source, "First product unit price not found"
    assert "2" in driver.page_source, "First product quantity not found"
    assert "£957.98" in driver.page_source, "First product total not found"
    
    # Second Product: ASUS GeForce RTX 4070 Super DUAL EVO OC
    product2_title = driver.find_element(By.XPATH, "//h4[contains(text(),'ASUS GeForce RTX 4070 Super DUAL EVO OC')]").text
    assert "ASUS GeForce RTX 4070 Super DUAL EVO OC" in product2_title, "Second product title not found"
    assert "£549.98" in driver.page_source, "Second product unit price not found"
    assert "3" in driver.page_source, "Second product quantity not found"
    assert "£1,649.94" in driver.page_source, "Second product total not found"
    
    # Verify Payments Section exists
    payments_heading = driver.find_element(By.XPATH, "//h1[contains(text(),'Payments')]").text
    assert "Payments" in payments_heading, "Payments section not found"
    
    driver.quit()
