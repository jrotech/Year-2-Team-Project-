from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import time
import pytest


def test_06_checkout():
   
    service = Service(ChromeDriverManager().install())
    options = webdriver.ChromeOptions()
    driver = webdriver.Chrome(service=service, options=options)
    wait = WebDriverWait(driver, 10)

    driver.get("http://localhost:8000")
    login_button = wait.until(EC.presence_of_element_located((By.XPATH, "//a[contains(text(),'Login')]")))
    login_button.click()

    # wait for login form and fill in credentials
    wait.until(EC.presence_of_element_located((By.NAME, "CustomerEmail"))).send_keys("john1@example.com")
    driver.find_element(By.NAME, "CustomerPassword").send_keys("SecurePass123")

    # click the login button
    driver.find_element(By.XPATH, "//input[@value='Login']").click() 

    # assert login success 
    found_bar = wait.until(EC.presence_of_element_located((By.XPATH, "//div[@id='nav']")))
    assert found_bar is not None

    driver.find_element(By.XPATH, "//a[contains(text(),'shop')]").click()

    gpu_checkbox = wait.until(EC.presence_of_element_located((By.XPATH,  "//label[text()='GPU']/preceding::input[@type='checkbox'][1]")))
    driver.execute_script("arguments[0].click();", gpu_checkbox)

    # wait for products to update
    time.sleep(2)  

    product_titles = driver.find_elements(By.CSS_SELECTOR, ".mantine-Title-root")

    #check that product results exist after applying category filter
    assert len(product_titles) > 0, "no products returned for 'GPU' category"

    # -------------------
    # search for a product (e.g. 'geforce')
    # -------------------
    search_input = driver.find_element(By.CSS_SELECTOR, "input[placeholder='Search products...']")
    search_input.clear()
    search_input.send_keys("GEFORCE")

    time.sleep(1)  # give time for debounce or filter to trigger
    driver.find_element(By.CSS_SELECTOR, "body").click()  

    time.sleep(2)  # wait for update

    product_titles = driver.find_elements(By.CSS_SELECTOR, ".mantine-Title-root")
    #verify that at least one product contains 'geforce' in the name
    assert any("geforce" in title.text.lower() for title in product_titles), "no products matched 'GEFORCE' search"

    #click first product
    driver.find_element(By.LINK_TEXT, "See More").click()

    plus_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//div[@data-position='right']//button")))

    plus_button.click()
    plus_button.click()

    buttons = driver.find_elements(By.CSS_SELECTOR, "button")
    for button in buttons:
        if "Add to cart" in button.text:
            button.click()
            break

    success_notification = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,".mantine-Notification-title")))
    assert "success" in success_notification.text.lower(), "Product did not get added to basket"

    search_input = driver.find_element(By.CSS_SELECTOR, "input[placeholder='Search products...']")
    search_input.clear()
    search_input.send_keys("AMD")

    driver.find_element(By.LINK_TEXT, "See More").click()

    plus_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//div[@data-position='right']//button")))

    plus_button.click()

    time.sleep(1)

    buttons = driver.find_elements(By.CSS_SELECTOR, "button")
    for button in buttons:
        if "Add to cart" in button.text:
            button.click()
            break

    success_notification = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,".mantine-Notification-title")))
    assert "success" in success_notification.text.lower(), "Product did not get added to basket"
    
    basket_link = wait.until(EC.element_to_be_clickable((By.XPATH, "//a[@href='/basket']")))
    basket_link.click()

    time.sleep(1)  

    wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "h4.mantine-Title-root")))
    product_titles = driver.find_elements(By.CSS_SELECTOR, "h4.mantine-Title-root")


    assert "amd ryzen 7 9800x3d" in product_titles[0].text.lower(), "Failed to add CPU"
    assert "asus geforce rtx 4070" in product_titles[1].text.lower(),"Failed to add GPU"

    prices = driver.find_elements(By.XPATH,"//h1[contains(text(),'£')]")

    
    checkout = driver.find_element(By.XPATH, "//a[@href='/checkout']")
    checkout.click()

    # fill in the checkout form fields using the stable data-path attribute and press next
    first_name = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "input[data-path='first_name']")))
    first_name.send_keys("John")

    last_name = driver.find_element(By.CSS_SELECTOR, "input[data-path='last_name']")
    last_name.send_keys("Doe")

    address = driver.find_element(By.CSS_SELECTOR, "input[data-path='address']")
    address.send_keys("123 Main Street")

    postal_code = driver.find_element(By.CSS_SELECTOR, "input[data-path='postal_code']")
    postal_code.send_keys("12345")

    email = driver.find_element(By.CSS_SELECTOR, "input[data-path='email']")
    email.send_keys("john.doe@example.com")

    phone_number = driver.find_element(By.CSS_SELECTOR, "input[data-path='phone_number']")
    phone_number.send_keys("5551234567")

    next_button = driver.find_element(By.XPATH, "//button[.//span[text()='Next']]")
    next_button.click()

    cardholder_name = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "input[data-path='cardHolderName']")))
    cardholder_name.send_keys("John Doe")

    card_number = driver.find_element(By.CSS_SELECTOR, "input[data-path='cardNumber']")
    card_number.send_keys("4242424242424242")

    expiry_date = driver.find_element(By.CSS_SELECTOR, "input[data-path='expiryDate']")
    expiry_date.send_keys("12/25")

    cvv = driver.find_element(By.CSS_SELECTOR, "input[data-path='cvv']")
    cvv.send_keys("123")

    pay_now = driver.find_element(By.XPATH, "//button[.//span[text()='Pay Now']]")
    pay_now.click()

    success_notification = wait.until(EC.presence_of_element_located((By.XPATH,"//h1[.//span[text()='Order Successful!']]")))
    assert "Order Successful!" in success_notification.text, "Order was not successful"
    time.sleep(1)

    driver.quit()


# 