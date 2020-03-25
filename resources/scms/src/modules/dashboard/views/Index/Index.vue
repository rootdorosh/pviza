<template>
  <div>
    <h1 class="page-title">Dashboard</h1>
    <b-row>
      <b-col>
        <main-content>
          <h4>Default headings</h4>
          <p>Basic headings for everyday use</p>
          <div class="widget-padding-md w-100 h-100 text-left border rounded">
            <b-row>
              <b-col sm="6">
                <h1>h1. Heading</h1>
                <h2>h2. Heading</h2>
                <h3>h3. Heading</h3>
                <h4>h4. Heading</h4>
                <h5>h5. Heading</h5>
                <h6>h6. Heading</h6>
              </b-col>
              <b-col sm="6">
                <h1 class="text-danger">h1. Heading</h1>
                <h2 class="text-warning">h2. Heading</h2>
                <h3 class="text-success">h3. Heading</h3>
                <h4 class="text-primary">h4. Heading</h4>
                <h5 class="text-info">h5. Heading</h5>
                <h6 class="text-inverse">h6. Heading</h6>
              </b-col>
            </b-row>
          </div>
          <h4 class="mt-5">Basic texts</h4>
          <p>Styling for common texts</p>
          <div class="widget-padding-md w-100 h-100 text-left border rounded">
            <p>You can use the mark tag to <mark>highlight</mark> text.</p>
            <p><del>This line of text is meant to be treated as deleted text.</del></p>
            <p><ins>This line of text is meant to be treated as
              an addition to the document.</ins></p>
            <p><small>This line of text is meant to be treated as fine print.</small></p>
            <p><em>This line rendered as italicized text.</em></p>
            <p><strong>This line rendered as bold text.</strong></p>
          </div>
        </main-content>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: 'Dashboard',
};
</script>
