{{/*
Expand the name of the chart.
*/}}
{{- define "hs-debaiter.name" -}}
{{- default .Chart.Name .Values.nameOverride | trunc 63 | trimSuffix "-" }}
{{- end }}

{{/*
Create chart name and version as used by the chart label.
*/}}
{{- define "hs-debaiter.chart" -}}
{{- printf "%s-%s" .Chart.Name .Chart.Version | replace "+" "_" | trunc 63 | trimSuffix "-" }}
{{- end }}


{{/*
Common labels
*/}}
{{- define "hs-debaiter.labels" -}}
helm.sh/chart: {{ include "hs-debaiter.chart" . }}
{{ include "hs-debaiter.selectorLabels" . }}
app.kubernetes.io/managed-by: {{ .Release.Service }}
{{- end }}

{{/*
Selector labels
*/}}
{{- define "hs-debaiter.selectorLabels" -}}
app.kubernetes.io/name: {{ include "hs-debaiter.name" . }}
app.kubernetes.io/instance: {{ .Release.Name }}
{{- end }}

{{/*
Common labels (database)
*/}}
{{- define "hs-debaiter.database.labels" -}}
helm.sh/chart: {{ include "hs-debaiter.chart" . }}
{{ include "hs-debaiter.database.selectorLabels" . }}
app.kubernetes.io/managed-by: {{ .Release.Service }}
{{- end }}

{{/*
Selector labels (database)
*/}}
{{- define "hs-debaiter.database.selectorLabels" -}}
app.kubernetes.io/name: {{ include "hs-debaiter.name" . }}-database
app.kubernetes.io/instance: {{ .Release.Name }}
{{- end }}
