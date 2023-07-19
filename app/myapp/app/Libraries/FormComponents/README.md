# Usage
### endpoint: /form-components/{tag}

## 1. Button
#### Endpoint: /form-components/button
> #### Body Request
```json
{
    "type": "button",
    "value": "Enter"
}
```
> #### Output
```html
<button type="button">Enter</button>
```
> #### Additional Support
#### Attributes
```json
{
    "type": "button" | "submit" | "reset",
    "attributes": {
        "class": "btn-class",
        "name": "btn-name",
        "disabled": true,
    }
}
```
#### Type Attributes
|  Type  |                        Attributes                       |
|:------:|:-------------------------------------------------------:|
| submit | `formaction`, `formenctype`, `formmethod`, `formtarget` |

## 2. Fieldset
#### Endpoint: /form-components/fieldset
> #### Body Request
```json
{
    "legend": "Personal Details" (optional),
}
```
> #### Output
```html
<fieldset id="fieldset_0">
    <legend>Personal Details</legend>
</fieldset>
```
> #### Additional Support
#### Attributes
```json
{
    "attributes": {
        "class": "btn-fieldset",
        "name": "btn-fieldset",
        "disabled": true,
    }
}
```

## 3. Input
#### Endpoint: /form-components/input
> #### Body Request 1
```json
{
    "label": "Do you like cats",
    "type": "checkbox"
    "attributes": {
        "value": "Yes"
    }
}
```
> #### Output 1
```html
<label for="checkbox_0">Do you like cats</label>
<input type="checkbox" id="checkbox_0" name="checkbox_0" value="Yes">
```
> #### Body Request 2
```json
{
    "label": "Do you the cats",
    "type": "text",
    "datalist": ["Yes", "No", "Extreme Yes"]
}
```
> #### Output 2
```html
<label for="input_0">Do you the cats</label>
<input type="text" list="input_0_list" name="input_0" id="input_0">
<datalist id="input_0_list">
    <option value="Yes">
    <option value="No">
    <option value="Extreme Yes">
</datalist>
```
> #### Additional Support
#### Attributes
```json
{
    "type": "button"
            "checkbox"
            "color"
            "date"
            "datetime-local"
            "email"
            "file"
            "hidden"
            "image"
            "month"
            "number"
            "radio"
            "password"
            "range"
            "reset"
            "search"
            "submit"
            "tel"
            "text"
            "time"
            "url"
            "week"
    "attributes": {
        "class": "input-class",
        "value": "default value",
        "disabled": true,
    }
}
```
#### Type Attributes
|      Type      |                        Attributes                        |
|:--------------:|:--------------------------------------------------------:|
| checkbox       | `required`, `checked`                                    |
| date           | `min`, `max`, `pattern`, `step`                          |
| datetime-local | `min`, `max`, `step`                                     |
| email          | `size`, `multiple`, `pattern`, `placeholder`, `required` |
| file           | `multiple`, `required`                                   |
| image          | `alt`, `height`, `width`                                 |
| month          | `min`, `max`, `step`                                     |
| number         | `min`, `max`, `required`, `step`                         |
| password       | `size`, `pattern`, `placeholder`, `required`             |
| radio          | `required`                                               |
| range          | `min`, `max`, `step`                                     |
| search         | `size`, `pattern`, `placeholder`, `required`             |
| tel            | `size`, `pattern`, `placeholder`, `required`             |
| text           | `readonly`, `size`, `pattern`, `placeholder`, `required` |
| time           | `min`, `max`, `step`                                     |
| url            | `size`, `pattern`, `placeholder`, `required`             |
| week           | `min`, `max`, `step`                                     |

## 4. Select
#### Endpoint: /form-components/select
> #### Body Request 1
```json
{
    "label": "Cat",
    "options": ["Yes", "No"]
}
```
> #### Output 1
```html
<label for="select_0">Cat</label>
<select name="select_0" id="select_0">
    <option value="Yes">Yes</option>
    <option value="No">No</option>
</select>
```
> #### Body Request 2
```json
{
    "label": "Cat",
    "optgroups": ["Option 1", "Option 2"]
    "options": [["Yes", "1"], ["No", "2"]]
}
```
> #### Output 2
```html
<label for="select_0">Cat</label>
<select name="select_0" id="select_0">
    <optgroup label="Option 1">
        <option value="Yes">Yes</option>
        <option value="1">1</option>
    </optgroup>
    <optgroup label="Option 2">
        <option value="No">No</option>
        <option value="2">2</option>
    </optgroup>
</select>
```
> #### Additional Support
#### Attributes
```json
{
    "attributes": {
        "class": "select-class",
        "name": "select-name",
        "disabled": true,
        "multiple": true,
        "required": true
    }
}
```

## 5. Textarea
#### Endpoint: /form-components/textarea
> #### Body Request
```json
{
    "label": "Do u cats",
}
```
> #### Output
```html
<label for="textarea_0">Do u cats</label>
<textarea id="textarea_0" name="textarea_0"></textarea>
```
> #### Additional Support
#### Attributes
```json
{
    "attributes": {
        "class": "btn-class",
        "name": "btn-name",
        "disabled": true,
        "rows": 10,
        "cols": 10,
        "placeholder": "Enter Text",
        "readonly": true,
        "required": true
    }
}
```
