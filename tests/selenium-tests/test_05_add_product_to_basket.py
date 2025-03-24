from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager
import time
import pytest


def test_05_add_product_to_basket():
   
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

    gpu_checkbox_label = wait.until(EC.presence_of_element_located((By.XPATH, "//h5[text()='GPU']")))
    gpu_checkbox_input = gpu_checkbox_label.find_element(By.XPATH, "./following-sibling::div//input[@type='checkbox']")
    # click it using JavaScript to avoid Mantine's custom styling interference
    driver.execute_script("arguments[0].click();", gpu_checkbox_input)

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
    assert "957.98" in prices[0].text, "Incorrect Price in Cart item 1"
    assert "1649.94" in prices[1].text, "Incorrect Price in Cart item 2"
    assert "Subtotal: £2607.92" in prices[2].text, "Incorrect Price in Total"

    clear_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[.//span[text()='Clear Basket']]")))
    clear_button.click()
    
    empty_message = wait.until(EC.presence_of_element_located((By.XPATH, "//h1[contains(text(),'Your basket is empty')]")))
    assert empty_message is not None, "Basket was not cleared"
  

    driver.quit()


# 