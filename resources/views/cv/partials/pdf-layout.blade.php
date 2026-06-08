@page {
    size: A4 portrait;
    margin: 12mm 14mm;
}

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
}

.section {
    margin-bottom: 5pt;
    page-break-inside: avoid;
}

.section > h2 {
    page-break-after: avoid;
}

.entry {
    page-break-inside: avoid;
    margin-bottom: 5pt;
}

.entry-header {
    page-break-after: avoid;
}

.entry-desc,
.summary,
p {
    orphans: 2;
    widows: 2;
}

.skill-group,
.skill-item {
    page-break-inside: avoid;
}
