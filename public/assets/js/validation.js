/**
 * Product form validation
 */
const productValidation = {
  validateName: function(name) {
    if (!name || name.trim() === '') {
      return 'Tên sản phẩm là bắt buộc.';
    }
    
    if (name.length < 10 || name.length > 100) {
      return 'Tên sản phẩm phải có từ 10 đến 100 ký tự.';
    }
    
    return null;
  },
  
  validatePrice: function(price) {
    if (!price || price === '') {
      return 'Giá sản phẩm là bắt buộc.';
    }
    
    const priceValue = parseFloat(price);
    if (isNaN(priceValue) || priceValue <= 0) {
      return 'Giá phải là một số dương lớn hơn 0.';
    }
    
    return null;
  },
  
  validateDescription: function(description) {
    if (!description || description.trim() === '') {
      return 'Mô tả sản phẩm là bắt buộc.';
    }
    
    return null;
  },
  
  validateForm: function(formElement) {
    try {
      const name = document.getElementById('name').value;
      const price = document.getElementById('price').value;
      const description = document.getElementById('description').value;
      
      console.log('Validating form:', { name, price, description });
      
      const errors = [];
      
      const nameError = this.validateName(name);
      if (nameError) errors.push(nameError);
      
      const priceError = this.validatePrice(price);
      if (priceError) errors.push(priceError);
      
      const descriptionError = this.validateDescription(description);
      if (descriptionError) errors.push(descriptionError);
      
      if (errors.length > 0) {
        alert(errors.join('\n'));
        return false;
      }
      
      return true;
    } catch (e) {
      console.error('Error in validation:', e);
      // If there's an error in validation, allow the form to submit
      return true;
    }
  },
  
  initFormValidation: function() {
    try {
      const productForms = document.querySelectorAll('.product-form');
      
      if (productForms.length === 0) {
        console.log('No product forms found');
        return;
      }
      
      console.log('Found', productForms.length, 'product forms');
      
      productForms.forEach(form => {
        form.addEventListener('submit', function(e) {
          const isValid = productValidation.validateForm(this);
          console.log('Form submission validation result:', isValid);
          
          if (!isValid) {
            e.preventDefault();
            return false;
          }
          return true;
        });
      });
      
      // Real-time validation feedback
      const nameInput = document.getElementById('name');
      if (nameInput) {
        nameInput.addEventListener('blur', function() {
          const error = productValidation.validateName(this.value);
          updateFeedback(this, error);
        });
      }
      
      const priceInput = document.getElementById('price');
      if (priceInput) {
        priceInput.addEventListener('blur', function() {
          const error = productValidation.validatePrice(this.value);
          updateFeedback(this, error);
        });
      }
      
      const descriptionInput = document.getElementById('description');
      if (descriptionInput) {
        descriptionInput.addEventListener('blur', function() {
          const error = productValidation.validateDescription(this.value);
          updateFeedback(this, error);
        });
      }
    } catch (e) {
      console.error('Error initializing validation:', e);
    }
  }
};

function updateFeedback(input, error) {
  let feedbackElement = input.nextElementSibling;
  
  // Find or create feedback element
  if (!feedbackElement || !feedbackElement.classList.contains('invalid-feedback')) {
    const existingFeedback = input.parentNode.querySelector('.invalid-feedback');
    if (existingFeedback) {
      feedbackElement = existingFeedback;
    } else {
      feedbackElement = document.createElement('div');
      feedbackElement.className = 'invalid-feedback';
      input.parentNode.insertBefore(feedbackElement, input.nextElementSibling);
    }
  }
  
  if (error) {
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');
    feedbackElement.textContent = error;
    feedbackElement.style.display = 'block';
  } else {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    feedbackElement.textContent = '';
    feedbackElement.style.display = 'none';
  }
}

// Initialize validation on DOM load
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, initializing validation');
  productValidation.initFormValidation();
}); 